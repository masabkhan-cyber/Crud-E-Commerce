<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;

class SettingsController extends Controller
{
    public function index()
    {
        $websiteName = Config::get('website-settings.website_name');
        $phoneNumber = Config::get('website-settings.phone_number');
        $email = Config::get('website-settings.email');
        $logoPath = Config::get('website-settings.logo_path');

        return view('settings.index', compact('websiteName', 'phoneNumber', 'email', 'logoPath'));
    }

    public function update(Request $request)
    {
        $validatedData = $request->validate([
            'website_name' => 'required',
            'phone_number' => 'required',
            'email' => 'required|email',
        ]);

        $configData = [
            'website_name' => $validatedData['website_name'],
            'phone_number' => $validatedData['phone_number'],
            'email' => $validatedData['email'],
        ];

        $configFilePath = base_path('config/website-settings.php');

        // Load the existing configuration file
        $config = File::getRequire($configFilePath);

        // Merge the updated configuration data
        $updatedConfig = array_merge($config, $configData);

        // Write the updated configuration to the file
        $content = "<?php\n\nreturn " . var_export($updatedConfig, true) . ";\n";
        File::put($configFilePath, $content);

        return redirect()->back()->with('success', 'Website information updated successfully.')->with('success_type', 'info');
    }

    public function updateLogo(Request $request)
    {
        // Check if the remove_logo checkbox is checked
        if ($request->has('remove_logo')) {
            $configFilePath = base_path('config/website-settings.php');
    
            // Load the existing configuration file
            $config = File::getRequire($configFilePath);
    
            // Delete the previous logo file if it's not the default logo
            $existingLogoPath = $config['logo_path'] ?? null;
            $defaultLogoPath = 'public/logos/default_logo.png';
    
            if ($existingLogoPath && $existingLogoPath !== $defaultLogoPath) {
                Storage::delete($existingLogoPath);
            }
    
            // Set the logo path to the default logo
            $config['logo_path'] = $defaultLogoPath;
    
            // Write the updated configuration to the file
            $content = "<?php\n\nreturn " . var_export($config, true) . ";\n";
            File::put($configFilePath, $content);
    
            return redirect()->back()->with('success', 'Logo removed successfully.')->with('success_type', 'logo');
        }
    
        // Check if a new logo file was uploaded
        if ($request->hasFile('logo')) {
            $validatedData = $request->validate([
                'logo' => 'image|mimes:jpeg,png,jpg,gif|max:2048',
            ]);
    
            $logoFile = $validatedData['logo'];
            $logoPath = $logoFile->store('public/logos');
    
            $configFilePath = base_path('config/website-settings.php');
    
            // Load the existing configuration file
            $config = File::getRequire($configFilePath);
    
            // Delete the previous logo file if it's not the default logo
            $existingLogoPath = $config['logo_path'] ?? null;
            $defaultLogoPath = 'public/logos/default_logo.png';
    
            if ($existingLogoPath && $existingLogoPath !== $defaultLogoPath) {
                Storage::delete($existingLogoPath);
            }
    
            // Set the logo path in the configuration
            $config['logo_path'] = $logoPath;
    
            // Write the updated configuration to the file
            $content = "<?php\n\nreturn " . var_export($config, true) . ";\n";
            File::put($configFilePath, $content);
    
            return redirect()->back()->with('success', 'Logo updated successfully.')->with('success_type', 'logo');
        }
    
        return redirect()->back()->withErrors('No logo file provided.');
    }
    
}

