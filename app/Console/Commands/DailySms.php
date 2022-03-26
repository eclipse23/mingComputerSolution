<?php

namespace App\Console\Commands;

use App\Models\Cart;
use App\Models\Product;
use App\Models\CartItem;
use App\Events\UpateProduct;
use Illuminate\Console\Command;
use App\Events\UpdateProductView;

class DailySms extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'sms:daily';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $orders = Cart::where('status', 'ready for pick-up')->get();

        foreach($orders as $order) {
            $diff = $orders->updated_at->diffInDays(date("Y/m/d"));
            $this->info($diff);

            $items = CartItem::where('cart_id', $order->id)->get();
            foreach($items as $item) {
                $product = Product::where('id', $item->product_id)->first();
                $product->update([
                    'reserved' => $product->reserved - $item->quantity
                ]);
                broadcast(new UpdateProductView($product))->toOthers();
                broadcast(new UpateProduct())->toOthers();
            }
        }

        return;
    }
}
