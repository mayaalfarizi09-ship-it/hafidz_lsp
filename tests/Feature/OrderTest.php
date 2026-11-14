<?php

namespace Tests\Feature;

use App\Models\Order;
use App\Models\Product;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class OrderTest extends TestCase
{
    use RefreshDatabase;

    public function test_product_page_payment_buttons_open_whatsapp_with_product_details(): void
    {
        $product = Product::create([
            'name' => 'Paket Internet',
            'price' => 350000,
            'unit' => '/ bulan',
        ]);

        $response = $this->get(route('products'));
        $message = 'Halo, saya ingin melakukan pembayaran untuk produk Paket Internet (Rp 350.000 / bulan). Mohon info langkah selanjutnya.';
        $whatsappUrl = 'https://wa.me/'.config('services.whatsapp.number').'?text='.rawurlencode($message);

        $response->assertOk()
            ->assertSee('Pembayaran')
            ->assertDontSee('Berlangganan')
            ->assertSee('Bayar Sekarang')
            ->assertSee('href="'.$whatsappUrl.'"', false)
            ->assertSee('target="_blank" rel="noopener noreferrer"', false);
    }

    public function test_order_form_shows_address_instead_of_quantity(): void
    {
        $user = User::factory()->create();
        $product = Product::create([
            'name' => 'Paket Internet',
            'price' => 350000,
            'unit' => '/ bulan',
        ]);

        $response = $this->actingAs($user)->get(route('order.create', $product));

        $response->assertOk()
            ->assertSee('Alamat')
            ->assertSee('Nomor Rekening Pengirim')
            ->assertSee('bankAccountField.hidden = !isBankTransfer;', false)
            ->assertSee('Bukti Transaksi')
            ->assertSee('enctype="multipart/form-data"', false)
            ->assertSee('WhatsApp')
            ->assertDontSee('value="whatsapp"', false)
            ->assertDontSee('Jumlah');

        $this->assertMatchesRegularExpression('/<div id="bank-account-field"\s+hidden\s*>/', $response->getContent());
    }

    public function test_customer_can_view_only_their_own_order_history(): void
    {
        $user = User::factory()->create();
        $otherUser = User::factory()->create();
        $product = Product::create([
            'name' => 'Paket Internet',
            'price' => 350000,
            'unit' => '/ bulan',
        ]);
        $ownOrder = Order::create([
            'order_number' => 'ORD-OWN',
            'user_id' => $user->id,
            'product_id' => $product->id,
            'quantity' => 1,
            'total_price' => 350000,
            'payment_method' => 'bank_transfer',
        ]);
        Order::create([
            'order_number' => 'ORD-OTHER',
            'user_id' => $otherUser->id,
            'product_id' => $product->id,
            'quantity' => 1,
            'total_price' => 350000,
        ]);

        $response = $this->actingAs($user)->get(route('order.history'));

        $response->assertOk()
            ->assertSee('Riwayat Pesanan')
            ->assertSee('ORD-OWN')
            ->assertSee('Paket Internet')
            ->assertSee('Transfer Bank')
            ->assertDontSee('ORD-OTHER');

        $this->assertSame([$ownOrder->id], $response->viewData('orders')->pluck('id')->all());
    }

    public function test_guest_is_redirected_from_order_history_to_login(): void
    {
        $this->get(route('order.history'))->assertRedirect(route('login'));
    }

    public function test_customer_can_place_an_order_with_address_and_payment_method(): void
    {
        $user = User::factory()->create();
        $product = Product::create([
            'name' => 'Paket Internet',
            'price' => 350000,
            'unit' => '/ bulan',
        ]);

        $response = $this->actingAs($user)->post(route('order.store', $product), [
            'address' => 'Jl. Merdeka No. 10, Bandung',
            'payment_method' => 'bank_transfer',
            'bank_account_number' => '1234567890',
        ]);

        $response->assertRedirect(route('products'));
        $this->assertDatabaseHas('orders', [
            'user_id' => $user->id,
            'product_id' => $product->id,
            'quantity' => 1,
            'total_price' => 350000,
            'address' => 'Jl. Merdeka No. 10, Bandung',
            'payment_method' => 'bank_transfer',
            'bank_account_number' => '1234567890',
        ]);
    }

    public function test_customer_can_upload_payment_proof_and_bank_account_is_saved(): void
    {
        Storage::fake('local');
        $user = User::factory()->create();
        $product = Product::create([
            'name' => 'Paket Internet',
            'price' => 350000,
            'unit' => '/ bulan',
        ]);

        $response = $this->actingAs($user)->post(route('order.store', $product), [
            'address' => 'Jl. Merdeka No. 10, Bandung',
            'payment_method' => 'bank_transfer',
            'bank_account_number' => '1234567890',
            'payment_proof' => UploadedFile::fake()->image('bukti.jpg'),
        ]);

        $response->assertRedirect(route('products'));
        $order = Order::firstOrFail();
        $this->assertSame('1234567890', $order->bank_account_number);
        $this->assertNotNull($order->payment_proof_path);
        Storage::disk('local')->assertExists($order->payment_proof_path);
    }

    public function test_bank_transfer_requires_sender_account_number(): void
    {
        $user = User::factory()->create();
        $product = Product::create([
            'name' => 'Paket Internet',
            'price' => 350000,
            'unit' => '/ bulan',
        ]);

        $response = $this->actingAs($user)->from(route('order.create', $product))->post(route('order.store', $product), [
            'address' => 'Jl. Merdeka No. 10, Bandung',
            'payment_method' => 'bank_transfer',
        ]);

        $response->assertRedirect(route('order.create', $product));
        $response->assertSessionHasErrors('bank_account_number');
        $this->assertDatabaseCount('orders', 0);
    }

    public function test_non_bank_payment_does_not_require_sender_account_number(): void
    {
        $user = User::factory()->create();
        $product = Product::create([
            'name' => 'Paket Internet',
            'price' => 350000,
            'unit' => '/ bulan',
        ]);

        $response = $this->actingAs($user)->post(route('order.store', $product), [
            'address' => 'Jl. Merdeka No. 10, Bandung',
            'payment_method' => 'e_wallet',
        ]);

        $response->assertRedirect(route('products'));
        $this->assertDatabaseHas('orders', [
            'user_id' => $user->id,
            'product_id' => $product->id,
            'payment_method' => 'e_wallet',
            'bank_account_number' => null,
            'payment_proof_path' => null,
        ]);
    }

    public function test_order_requires_a_valid_payment_method(): void
    {
        $user = User::factory()->create();
        $product = Product::create([
            'name' => 'Paket Internet',
            'price' => 350000,
            'unit' => '/ bulan',
        ]);

        $response = $this->actingAs($user)->from(route('order.create', $product))->post(route('order.store', $product), [
            'address' => 'Jl. Merdeka No. 10, Bandung',
            'payment_method' => 'whatsapp',
        ]);

        $response->assertRedirect(route('order.create', $product));
        $response->assertSessionHasErrors('payment_method');
        $this->assertDatabaseCount('orders', 0);
    }

}
