<?php

namespace SocialiteProviders\BattleNet;

use SocialiteProviders\Manager\SocialiteWasCalled;

class BattleNetExtendSocialite
{
    /**
     * Execute the provider.
     */
    public function handle(SocialiteWasCalled $socialiteWasCalled)
    {
        $socialiteWasCalled->extendSocialite('battlenet', __NAMESPACE__.'\Provider');
    }
}
