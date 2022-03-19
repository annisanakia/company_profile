<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Auth\Middleware\Authenticate as Middleware;
use Illuminate\Support\Facades\Auth;
use Models\job;
use Models\user_group;

class Authenticate extends Middleware
{
    /**
     * Get the path the user should be redirected to when they are not authenticated.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return string|null
     */
    protected function redirectTo($request)
    {
        if (! $request->expectsJson()) {
            return route('login');
        }
        if (auth()->user()) {
            return '/admin';
        }
    }

    public function handle($request, Closure $next, ...$guards){
        // dd($request->age);
        if (Auth::guard($guards)->check()) {
            $user_group = user_group::select(['groups_id'])->where('users_id', '=', Auth::user()->getAttributes()['id'])->get();
            $this->user_groups = array();
            foreach ($user_group as $ug) {
                $this->user_groups[] = $ug->groups_id;
            }

            $request->session()->put('groups_id', $this->user_groups);

            if (!$request->session()->has('group_as')) {
                $group_as = user_group::select(['groups_id'])
                        ->where('users_id', '=', Auth::user()->getAttributes()['id'])
                        ->where('default', '=', 1)
                        ->first();

                if($group_as){
                    $request->session()->put('group_as', $group_as->groups_id);
                }
            }
            
            $ng_department_id = Auth::user()->ng_department_id;
            $ng_department_ids = \Models\ng_department::getChildRecursive($ng_department_id);
            
            $request->session()->put('ng_department_ids', $ng_department_ids);
            
            $code = $request->segment(1);
            if ($request->segment(1) == 'blank') {
                $code = $request->segment(2);
            }

            $job = job::whereHas('acl', function($builder) {
                        $builder->where('groups_id', Session()->get('group_as', ''));
                    })
                    ->where('code', $code)
                    ->get();

            if (count($job) <= 0) {
                if ($request->segment(1) != '' && $request->segment(1) != 'admin') {
                    // dd($job,Session()->get('group_as', ''),$request->segment(1),view()->exists('errors.unauthorized'));
                    if (view()->exists('errors.unauthorized')) {
                        return response()->view('errors.unauthorized');
                    } else {
                        return response('Unauthorized.', 401);
                    }
                }
            }
        } else {
            if ($request->ajax()) {
                return '<script>window.location.href = "'.url('login').'";</script>';
            }
            return redirect()->guest('login');
        }

        return $next($request);
    }

    
}