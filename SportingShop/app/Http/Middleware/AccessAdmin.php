<?php

namespace App\Http\Middleware;
use App\Admin;
use Auth;
use Closure;
use Illuminate\Support\Facades\Route;
class AccessAdmin
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    protected $admin;
    public function __construct(Admin $admin){
        $this->admin = $admin;
    }
  
    public function handle($request, Closure $next)
    {
      

        if(Auth::user()->hasRole('admin')){
                return $next($request);
            }else{
              return redirect('/dashboard');   
            }
        }
        
       
    
}
