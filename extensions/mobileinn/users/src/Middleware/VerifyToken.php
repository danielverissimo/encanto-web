<?php namespace Mobileinn\Users\Middleware;

use Closure;
use Sentinel;

class VerifyToken {
	public function handle($request, Closure $next)
	{
		if (strpos($request->path(), 'api/v1') === false || $request->is('api/v1/auth')) {
			return $next($request);
		}

		$token = input('token',
			input('auth',
				$request->header('X-Authenticate',
					$request->header('X-Auth')
				)
			)
		);

		if (! Sentinel::getPersistenceRepository()->findUserByPersistenceCode($token)) {
			return response(['message' => trans('mobileinn/users::users/errors.invalid_credentials')], 401);
		}

		return $next($request);
	}
}