<?php

use App\Models\Department;
use App\Models\Division;
use App\Models\Group;
use App\Models\Section;
use App\Models\User;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('user_has_head_offices', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(User::class)->constrained()->cascadeOnDelete();
            $table->string('office');
            $table->foreignIdFor(Group::class)->constrained()->cascadeOnDelete();
            $table->foreignIdFor(Division::class)->constrained()->cascadeOnDelete();
            $table->foreignIdFor(Department::class)->constrained()->cascadeOnDelete()->nullable();
            $table->foreignIdFor(Section::class)->constrained()->cascadeOnDelete();
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('user_has_head_offices');
    }
};
