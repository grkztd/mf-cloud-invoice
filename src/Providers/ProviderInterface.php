<?php

namespace Grkztd\MfCloud\Providers;

interface ProviderInterface{
    /**
     * Redirect the user to the authentication page for the provider.
     *
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function redirect();
}
