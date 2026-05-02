<?php

use App\Models\Category;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration
{
    public function up(): void
    {
        // Update Fashion Category
        Category::where('slug', 'fashion')->update([
            'image_url' => 'https://images.unsplash.com/photo-1490481651871-ab68de25d43d?q=80&w=2070&auto=format&fit=crop',
            'subtitle' => 'Spring / Summer 2026'
        ]);

        // Update Tech Category
        Category::where('slug', 'tech')->update([
            'image_url' => 'https://images.unsplash.com/photo-1550009158-9ebf69173e03?q=80&w=2101&auto=format&fit=crop',
            'subtitle' => 'Next-Gen Innovation'
        ]);
    }

    public function down(): void
    {
        // No rollback needed for data update
    }
};
