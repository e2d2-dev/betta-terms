<?php

namespace Betta\Terms;

use Betta\Terms\TermsManager\CanBeDisabled;
use Betta\Terms\TermsManager\CanSetupConsentConditions;
use Betta\Terms\TermsManager\HasConfig;
use Betta\Terms\TermsManager\HasConsentConditions;
use Betta\Terms\TermsManager\HasGuards;
use Betta\Terms\TermsManager\HasMiddleware;
use Betta\Terms\TermsManager\HasModels;
use Betta\Terms\TermsManager\HasPanels;
use Betta\Terms\TermsManager\HasResources;
use Betta\Terms\TermsManager\HasSession;
use Betta\Terms\TermsManager\HasTables;
use Betta\Terms\TermsManager\InteractsWithUrls;

class TermsManager
{
    use CanBeDisabled;
    use CanSetupConsentConditions;
    use HasConfig;
    use HasConsentConditions;
    use HasGuards;
    use HasMiddleware;
    use HasModels;
    use HasPanels;
    use HasResources;
    use HasSession;
    use HasTables;
    use InteractsWithUrls;
}
