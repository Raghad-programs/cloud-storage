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
use App\Policies\UserPolicy;
use Illuminate\Support\Facades\Log;
class ProfileController extends Controller
{
    /**
     * Display the user's profile form.
     */
    public function edit($id){
        $user = User::findOrFail($id);

        if (auth()->user()->can('viewAny', $user)){
        return view('profile.edit')->with('user',$user);
        } else {
        // User is not authorized, handle the unauthorized access
        flash()->error('Unauthorized to access that profile');
        return back();
        // abort(403, 'Unauthorized');
        }
    }
    
    /**
     * Update the user's profile information.
     */
    public function update(Request $request, $id)
    {
        $user = User::findOrFail($id);
        
        $validatedData = $request->validate([
            'first_name' => 'string|max:255',
            'last_name' => 'string|max:255',
            'email' => 'string|email|max:255'.$user->id,
            'phone_number' => 'string|max:10',
            'linkedin' => 'url|max:255'
        ]);
    
        $user->update($validatedData);
        return redirect()->route('profile.show',$user->id);
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
        if (auth()->user()->can('viewAny', $user)) {
            // User is authorized, proceed with the action
    
            $filesNumber = DepartmentStorage::where('department_id', $user->Depatrment_id)
                ->where('user_id', $id)
                ->count();
            $participationPercentages = $this->calculateParticipationPercentages($user);
            $userStorageLimitInMB = $this->getEmployeeStorage($user->id);
            $currentUserDepartment = $user->Depatrment_id; //user department
            $categories = Category::where('department_id', $currentUserDepartment)->get();
    
            $fileSizesEn = [];
            $fileSizesAr = [];
            $totalFileSize = 0;
    
            foreach ($categories as $category) {
                $categoryFileSize = DepartmentStorage::where('department_id', $currentUserDepartment)
                    ->where('category_id', $category->id)
                    ->where('user_id', $id)
                    ->sum('file_size');
                
                $sizeInMB = round($categoryFileSize / 1024 / 1024, 2); // Convert bytes to MB and round to 2 decimal places
    
                $fileSizesEn[$category->name] = $sizeInMB;
                $fileSizesAr[$category->name_ar] = $sizeInMB;
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
                'fileSizesEn' => $fileSizesEn,
                'fileSizesAr' => $fileSizesAr,
                'totalFileSize' => $totalFileSizeInMB
            ]);
        } else {
            // User is not authorized, handle the unauthorized access
            flash()->error('Unauthorized to access that profile');
            return back();
            // abort(403, 'Unauthorized');
        }
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
