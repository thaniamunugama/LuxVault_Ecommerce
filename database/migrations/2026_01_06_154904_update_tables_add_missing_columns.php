<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Update customers table
        if (Schema::hasTable('customers')) {
            Schema::table('customers', function (Blueprint $table) {
                // Drop old columns if they exist
                if (Schema::hasColumn('customers', 'user_id')) {
                    $table->dropForeign(['user_id']);
                    $table->dropColumn('user_id');
                }
                if (Schema::hasColumn('customers', 'full_name')) {
                    $table->dropColumn('full_name');
                }
                
                // Add new columns if they don't exist
                if (!Schema::hasColumn('customers', 'fname')) {
                    $table->string('fname', 100)->after('customer_id');
                }
                if (!Schema::hasColumn('customers', 'lname')) {
                    $table->string('lname', 100)->after('fname');
                }
                if (!Schema::hasColumn('customers', 'email')) {
                    $table->string('email', 150)->unique()->after('lname');
                }
                if (!Schema::hasColumn('customers', 'password')) {
                    $table->string('password', 255)->after('email');
                }
            });
        }

        // Update sellers table
        if (Schema::hasTable('sellers')) {
            Schema::table('sellers', function (Blueprint $table) {
                // Drop old columns if they exist
                if (Schema::hasColumn('sellers', 'user_id')) {
                    $table->dropForeign(['user_id']);
                    $table->dropColumn('user_id');
                }
                if (Schema::hasColumn('sellers', 'name')) {
                    $table->dropColumn('name');
                }
                
                // Add new columns if they don't exist
                if (!Schema::hasColumn('sellers', 'fname')) {
                    $table->string('fname', 100)->after('seller_id');
                }
                if (!Schema::hasColumn('sellers', 'lname')) {
                    $table->string('lname', 100)->after('fname');
                }
                if (!Schema::hasColumn('sellers', 'email')) {
                    $table->string('email', 150)->unique()->after('lname');
                }
                if (!Schema::hasColumn('sellers', 'password')) {
                    $table->string('password', 255)->after('email');
                }
                if (!Schema::hasColumn('sellers', 'is_admin')) {
                    $table->boolean('is_admin')->default(false)->after('password');
                }
            });
        }

        // Update products table
        if (Schema::hasTable('products')) {
            Schema::table('products', function (Blueprint $table) {
                // Drop old columns if they exist
                if (Schema::hasColumn('products', 'product_code')) {
                    // Drop trigger first
                    DB::unprepared('DROP TRIGGER IF EXISTS trg_generate_product_code');
                    $table->dropColumn('product_code');
                }
                if (Schema::hasColumn('products', 'product_name')) {
                    $table->dropColumn('product_name');
                }
                
                // Add new columns if they don't exist
                if (!Schema::hasColumn('products', 'name')) {
                    $table->string('name', 255)->after('brand');
                }
                if (!Schema::hasColumn('products', 'description')) {
                    $table->text('description')->nullable()->after('name');
                }
                if (!Schema::hasColumn('products', 'image')) {
                    $table->string('image', 255)->nullable()->after('quantity');
                }
                
                // Update brand enum if needed
                if (Schema::hasColumn('products', 'brand')) {
                    DB::statement("ALTER TABLE products MODIFY COLUMN brand ENUM('Hermes', 'Chanel', 'Charles and Keith', 'Coach', 'YSL')");
                }
            });
        }

        // Update cart table
        if (Schema::hasTable('cart')) {
            Schema::table('cart', function (Blueprint $table) {
                // Drop old columns if they exist
                if (Schema::hasColumn('cart', 'created_at')) {
                    $table->dropColumn('created_at');
                }
                if (Schema::hasColumn('cart', 'updated_at')) {
                    $table->dropColumn('updated_at');
                }
                
                // Add new columns if they don't exist
                if (!Schema::hasColumn('cart', 'quantity')) {
                    $table->integer('quantity')->default(1)->after('product_id');
                }
                if (!Schema::hasColumn('cart', 'image')) {
                    $table->string('image', 255)->nullable()->after('quantity');
                }
                
                // Add unique constraint if it doesn't exist
                $indexes = DB::select("SHOW INDEXES FROM cart WHERE Key_name = 'cart_customer_id_product_id_unique'");
                if (empty($indexes)) {
                    $table->unique(['customer_id', 'product_id']);
                }
            });
        }

        // Update orders table
        if (Schema::hasTable('orders')) {
            Schema::table('orders', function (Blueprint $table) {
                // Drop old columns if they exist
                if (Schema::hasColumn('orders', 'order_number')) {
                    $table->dropColumn('order_number');
                }
                if (Schema::hasColumn('orders', 'total_amount')) {
                    $table->dropColumn('total_amount');
                }
                
                // Add new columns if they don't exist
                if (!Schema::hasColumn('orders', 'total_price')) {
                    $table->decimal('total_price', 10, 2)->after('customer_id');
                }
                if (!Schema::hasColumn('orders', 'status')) {
                    $table->enum('status', ['pending', 'received', 'processing', 'delivered'])->default('pending')->after('total_price');
                }
                // Shipping address fields
                if (!Schema::hasColumn('orders', 'shipping_first_name')) {
                    $table->string('shipping_first_name', 100)->nullable()->after('order_date');
                }
                if (!Schema::hasColumn('orders', 'shipping_last_name')) {
                    $table->string('shipping_last_name', 100)->nullable()->after('shipping_first_name');
                }
                if (!Schema::hasColumn('orders', 'shipping_phone')) {
                    $table->string('shipping_phone', 20)->nullable()->after('shipping_last_name');
                }
                if (!Schema::hasColumn('orders', 'shipping_address')) {
                    $table->text('shipping_address')->nullable()->after('shipping_phone');
                }
                if (!Schema::hasColumn('orders', 'shipping_city')) {
                    $table->string('shipping_city', 100)->nullable()->after('shipping_address');
                }
                if (!Schema::hasColumn('orders', 'shipping_state')) {
                    $table->string('shipping_state', 100)->nullable()->after('shipping_city');
                }
                if (!Schema::hasColumn('orders', 'shipping_postal_code')) {
                    $table->string('shipping_postal_code', 20)->nullable()->after('shipping_state');
                }
                if (!Schema::hasColumn('orders', 'shipping_country')) {
                    $table->string('shipping_country', 100)->nullable()->after('shipping_postal_code');
                }
            });
        }

        // Update order_items table
        if (Schema::hasTable('order_items')) {
            Schema::table('order_items', function (Blueprint $table) {
                // Drop old columns if they exist
                if (Schema::hasColumn('order_items', 'product_code')) {
                    $table->dropColumn('product_code');
                }
                if (Schema::hasColumn('order_items', 'product_name')) {
                    $table->dropColumn('product_name');
                }
                if (Schema::hasColumn('order_items', 'unit_price')) {
                    $table->dropColumn('unit_price');
                }
                if (Schema::hasColumn('order_items', 'subtotal')) {
                    $table->dropColumn('subtotal');
                }
                
                // Add new columns if they don't exist
                if (!Schema::hasColumn('order_items', 'product_id')) {
                    $table->unsignedBigInteger('product_id')->after('order_id');
                    $table->foreign('product_id')->references('product_id')->on('products')->onDelete('cascade');
                }
                if (!Schema::hasColumn('order_items', 'seller_id')) {
                    $table->unsignedBigInteger('seller_id')->after('product_id');
                    $table->foreign('seller_id')->references('seller_id')->on('sellers')->onDelete('cascade');
                }
                if (!Schema::hasColumn('order_items', 'quantity')) {
                    $table->integer('quantity')->default(1)->after('seller_id');
                }
                if (!Schema::hasColumn('order_items', 'price')) {
                    $table->decimal('price', 10, 2)->after('quantity');
                }
                if (!Schema::hasColumn('order_items', 'image')) {
                    $table->string('image', 255)->nullable()->after('price');
                }
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // This migration is complex to reverse, so we'll leave it empty
        // If needed, run migrate:fresh to reset everything
    }
};
