<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileUpdateRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;
use App\Models\User;
use App\Models\DepartmentStorage;
use App\Models\Category;
class ProfileController extends Controller
{
    /**
     * Display the user's profile form.
     */
    public function edit($id){
        $user = User::findOrFail($id);
        return view('profile.edit')->with('user',$user);
    }
    
    /**
     * Update the user's profile information.
     */
    public function update(Request $request, $id)
    {
        $user = User::findOrFail($id);
        
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255',
            
        ]);
    
        $user->update($validatedData);
        return redirect()->route('profile.edit',$user->id);
    }


    //  public function show($id ,Request $request) 
    //  {
    //     $user = User::findOrFail($id);
    
    //     return view('profile.partials.profile', [
    //         'user' => $request->user(),
    //     ]);
    // }
     
    /**
     * Delete the user's account.
     */
    public function destroy(Request $request): RedirectResponse
    {
        $request->validateWithBag('userDeletion', [
            'password' => ['required', 'current_password'],
        ]);

        $user = $request->user();

        Auth::logout();

        $user->delete();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return Redirect::to('/');
    }

    public function show($id)
{
    $user = User::findOrFail($id);
    $filesNumber = DepartmentStorage::where('department_id', $user->Depatrment_id)
                                       ->where('user_id', $id)
                                       ->count();
    $participationPercentages = $this->calculateParticipationPercentages($user);
    $userStorageLimitInMB = $this->getEmployeeStorage($user->id);
    $currentUserDepartment = $user->Depatrment_id; //user department
    $categories = Category::where('department_id', $currentUserDepartment)->get();
    $fileSizes = [];
        $totalFileSize = 0;
        foreach ($categories as $category) {
            $categoryFileSize = DepartmentStorage::where('department_id', $currentUserDepartment)
                                                ->where('category_id', $category->id)
                                                ->where('user_id', $id)
                                                ->sum('file_size');
            $fileSizes[$category->name] = round($categoryFileSize / 1024/ 1024, 2); // Convert bytes to MB and round to 2 decimal places
        }
    $totalFileSize = DepartmentStorage::where('user_id', $id)
    ->sum('file_size');

    $totalFileSizeInMB = round($totalFileSize / 1024 / 1024, 2);
    $usagePercentage = ($totalFileSize / ($userStorageLimitInMB * 1024 * 1024)) * 100;

    return view('profile.partials.profile')->with([
        'user' => $user,
        'filesNumber' => $filesNumber,
        'userStorageLimit' => $userStorageLimitInMB,
        'usagePercentage' => $usagePercentage,
        'participationPercentages' => $participationPercentages,
        'fileSizes'=> $fileSizes,
        'totalFileSize' => $totalFileSizeInMB
   ]);
}

private function calculateParticipationPercentages($user)
    {
        $totalFiles = DepartmentStorage::where('department_id', $user->Depatrment_id)
            ->where('user_id', $user->id)
            ->count();

        $participationPercentages = [];

        $currentUserDepartment = $user->Depatrment_id;
        $categories = Category::where('department_id', $currentUserDepartment)->get();

        foreach ($categories as $category) {
            $fileCount = $category->departmentStorages()
                ->where('department_id', auth()->user()->Depatrment_id)
                ->where('user_id', $user->id)
                ->count();
            if ($totalFiles > 0) {
            $percentage = ($fileCount / $totalFiles) * 100;
            $participationPercentages[$category->name] = round($percentage, 2);
            }else{
                $participationPercentages[$category->name] = 0;
            }
         
        }

        return $participationPercentages;
    }

    public function getEmployeeStorage($userID){
        $user=User::findOrFail($userID);
        $size = $user->storage_size;
        return $size;
    }
}
