<?php

namespace App\Http\Controllers\api\v1;

use App\Models\Task;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Validation\Rules;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Auth\Events\Registered;
use Illuminate\Validation\ValidationException;

class AuthController extends Controller
{

    //!====================login function================================
    public function login(Request $request): JsonResponse
    {
        try {
            // Returns validated data if successful 
            //Throws ValidationException if validation fails
            $credentials = $request->validate([
                'email' => ['required', 'email'],
                'password' => ['required', 'min:8'],
            ], [
                //Overrides default validation messages
                'email.required' => 'البريد الإلكتروني مطلوب',
                'email.email' => 'يجب أن يكون البريد الإلكتروني بصيغة صحيحة',
                'password.required' => 'كلمة المرور مطلوبة',
                'password.min' => 'يجب أن تكون كلمة المرور 8 أحرف على الأقل',
            ]);

            if (!Auth::attempt($credentials)) { //Tries to authenticate with credentials
                /*failure Response:+Returns HTTP 401 Unauthorized+ Generic message for security (doesn't reveal which field is incorrect)*/
                return response()->json([
                    'success' => false,
                    'message' => 'Invalid credentials'
                ], 401);
            }

            $user = $request->user(); //Gets authenticated user instance
            $token = $user->createToken('MobileApp')->plainTextToken; //Creates a token named 'auth_token'


            // Success Response
            return response()->json([
                'success' => true,
                'message' => 'Login successful',
                'data' => [
                    'user' => $user->only(['id', 'name', 'email']),
                    'token' => $token
                ]
            ], 200);


            //Validation Exception Handling
        } catch (ValidationException $e) {
            return response()->json([
                'success' => false,
                'message' => 'Validation failed',
                'errors' => $e->errors() //Detailed error messages for each invalid field
            ], 422);


            // General Exception Handling (Catches all other exceptions)
        } catch (\Exception $e) {
            report($e);
            return response()->json([
                'success' => false,
                'message' => 'Login failed',
                'error' => config('app.debug') ? $e->getMessage() : null
            ], 500);
        }
    }


    //!====================register function================================
    public function register(Request $request): JsonResponse
    {
        try {
            $validated = $request->validate([
                'name' => ['required', 'string', 'max:255'],
                'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:' . User::class],
                'password' => ['required', 'confirmed', Rules\Password::defaults()],
            ], [
                'name.required' => 'الاسم مطلوب',
                'name.string' => 'يجب أن يكون الاسم نصًا',
                'name.max' => 'يجب ألا يزيد الاسم عن 255 حرفًا',
                'email.required' => 'البريد الإلكتروني مطلوب',
                'email.string' => 'يجب أن يكون البريد الإلكتروني نصًا',
                'email.lowercase' => 'يجب أن يكون البريد الإلكتروني بحروف صغيرة',
                'email.email' => 'يجب أن يكون البريد الإلكتروني بصيغة صحيحة',
                'email.max' => 'يجب ألا يزيد البريد الإلكتروني عن 255 حرفًا',
                'email.unique' => 'البريد الإلكتروني مستخدم بالفعل',
                'password.required' => 'كلمة المرور مطلوبة',
                'password.confirmed' => 'تأكيد كلمة المرور غير متطابق',
                'password.min' => 'يجب أن تكون كلمة المرور 8 أحرف على الأقل',
            ]);
            DB::beginTransaction();
            $user = User::create([
                'name' => $validated['name'],
                'email' => $validated['email'],
                'password' => Hash::make($validated['password']),
            ]);

            // event(new Registered($user)); //for Email Verification

            // Create API token
            $token = $user->createToken('MobileApp')->plainTextToken;
            DB::commit();
            return response()->json([
                'success' => true,
                'message' => 'Registration successful.',
                'data' => [
                    'user' => $user->only(['id', 'name', 'email', 'created_at', 'updated_at']),
                    'token' => $token
                ]
            ], 201);
        } catch (ValidationException $e) {
            return response()->json([
                'success' => false,
                'message' => 'Validation failed',
                'errors' => $e->errors()
            ], 422);
        } catch (\Exception $e) {
            report($e); // Log the error
            return response()->json([
                'success' => false,
                'message' => 'Registration failed',
                'error' => config('app.debug') ? $e->getMessage() : null
            ], 500);
        }
    }
    
    //!====================logout function================================
    public function logout(Request $request): JsonResponse
    {
        try {
            $request->user()->currentAccessToken()->delete();
            return response()->json([
                'success' => true,
                'message' => 'Logout successful'
            ], 200);
        } catch (\Exception $e) {
            report($e);
            return response()->json([
                'success' => false,
                'message' => 'Logout failed',
                'error' => config('app.debug') ? $e->getMessage() : null
            ], 500);
        }
    }
}
