<?php

namespace App\Http\Middleware;

use App\repository\Contracts\RegistrationRepositoryInterface;
use Closure;
use Exception;
use Illuminate\Http\Request;

class CheckRegistrationProgress
{

    public function __construct(private readonly RegistrationRepositoryInterface $RegistrationRepository){}

    /**
     * @throws Exception
     */
    public function handle(Request $request, Closure $next, int $requiredStatus)
    {
        $registrationStep = $this->RegistrationRepository->findDraftUserById($request->id);
        if (!$registrationStep) {
            abort(401);
        }

        if ($registrationStep->current_status < $requiredStatus) {
            $redirectRoute = $requiredStatus === 2 ? 'registration' : 'registration2';
            return redirect()->route($redirectRoute);
        }

        return $next($request);
    }
}
