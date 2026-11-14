<?php

namespace App\Filament\Resources\Orders;

use App\Filament\Resources\Orders\Pages\CreateOrder;
use App\Filament\Resources\Orders\Pages\EditOrder;
use App\Filament\Resources\Orders\Pages\ListOrders;
use App\Models\Order;
use App\Models\Product;
use App\Models\User;
use BackedEnum;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;

class OrderResource extends Resource
{
    protected static ?string $model = Order::class;
    protected static ?string $modelLabel = 'Penjualan';
    protected static ?string $pluralModelLabel = 'Penjualan';
    protected static ?string $navigationLabel = 'Data Penjualan';
    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedShoppingCart;
    protected static ?int $navigationSort = 3;

    public static function form(Schema $schema): Schema
    {
        return $schema->components([
            TextInput::make('order_number')->label('Nomor transaksi')->disabled()->dehydrated(false),
            Select::make('user_id')->label('User')->options(fn () => User::query()->orderBy('name')->pluck('name', 'id'))->searchable()->required(),
            Select::make('product_id')->label('Produk')->options(fn () => Product::query()->orderBy('name')->pluck('name', 'id'))->searchable()->required(),
            Textarea::make('address')->label('Alamat')->required()->maxLength(1000)->columnSpanFull(),
            Select::make('payment_method')->label('Metode pembayaran')->options(Order::PAYMENT_METHODS)->required(),
            TextInput::make('total_price')->label('Total harga')->numeric()->prefix('Rp')->required(),
            Select::make('order_status')->label('Status pesanan')->options([
                'pending' => 'Menunggu', 'confirmed' => 'Dikonfirmasi', 'processing' => 'Diproses',
                'completed' => 'Selesai', 'cancelled' => 'Dibatalkan',
            ])->required(),
            Select::make('payment_status')->label('Status pembayaran')->options([
                'unpaid' => 'Belum Bayar', 'paid' => 'Lunas', 'refunded' => 'Dikembalikan',
            ])->required(),
            Textarea::make('notes')->label('Catatan')->columnSpanFull(),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->defaultSort('created_at', 'desc')
            ->columns([
                TextColumn::make('order_number')->label('No. transaksi')->searchable()->copyable(),
                TextColumn::make('user.name')->label('Pelanggan')->searchable(),
                TextColumn::make('product.name')->label('Produk')->searchable(),
                TextColumn::make('address')->label('Alamat')->limit(40)->tooltip(fn (Order $record): ?string => $record->address),
                TextColumn::make('payment_method')->label('Metode pembayaran')->formatStateUsing(fn (?string $state): string => Order::PAYMENT_METHODS[$state] ?? $state ?? '-'),
                TextColumn::make('total_price')->label('Total')->money('IDR', locale: 'id')->sortable(),
                TextColumn::make('order_status')->label('Status pesanan')->badge()->formatStateUsing(fn (string $state): string => [
                    'pending' => 'Menunggu', 'confirmed' => 'Dikonfirmasi', 'processing' => 'Diproses',
                    'completed' => 'Selesai', 'cancelled' => 'Dibatalkan',
                ][$state] ?? $state),
                TextColumn::make('payment_status')->label('Pembayaran')->badge()->formatStateUsing(fn (string $state): string => [
                    'unpaid' => 'Belum Bayar', 'paid' => 'Lunas', 'refunded' => 'Dikembalikan',
                ][$state] ?? $state),
                TextColumn::make('created_at')->label('Tanggal')->dateTime('d M Y H:i')->sortable(),
            ])
            ->filters([
                SelectFilter::make('order_status')->label('Status pesanan')->options([
                    'pending' => 'Menunggu', 'confirmed' => 'Dikonfirmasi', 'processing' => 'Diproses',
                    'completed' => 'Selesai', 'cancelled' => 'Dibatalkan',
                ]),
                SelectFilter::make('payment_status')->label('Status pembayaran')->options([
                    'unpaid' => 'Belum Bayar', 'paid' => 'Lunas', 'refunded' => 'Dikembalikan',
                ]),
            ])
            ->recordActions([EditAction::make(), DeleteAction::make()])
            ->toolbarActions([BulkActionGroup::make([DeleteBulkAction::make()])]);
    }

    public static function getPages(): array
    {
        return [
            'index' => ListOrders::route('/'),
            'create' => CreateOrder::route('/create'),
            'edit' => EditOrder::route('/{record}/edit'),
        ];
    }
}
