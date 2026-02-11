<?php

use App\Models\User;
use Illuminate\Support\Facades\Hash;

// Check if admin exists
$admin = User::where('username', 'admin')->first();

if ($admin) {
    echo "Admin user found:\n";
    echo "ID: " . $admin->id . "\n";
    echo "Name: " . $admin->name . "\n";
    echo "Username: " . $admin->username . "\n";
    echo "Email: " . $admin->email . "\n";
    echo "Role: " . $admin->role . "\n";
    echo "Password hash exists: " . (bool)$admin->password . "\n";
    
    // Test password verification
    $testPassword = 'admin123';
    $passwordMatch = Hash::check($testPassword, $admin->password);
    echo "Password 'admin123' matches: " . ($passwordMatch ? 'YES' : 'NO') . "\n";
} else {
    echo "Admin user not found!\n";
    echo "Creating admin user...\n";
    
    User::create([
        'name' => 'Administrator',
        'username' => 'admin',
        'email' => 'admin@atmi.ac.id',
        'password' => Hash::make('admin123'),
        'role' => 'admin',
    ]);
    
    echo "Admin user created successfully!\n";
}
?>
