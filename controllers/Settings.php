<?php namespace Chkilel\Icones\Controllers;

use Backend\Classes\Controller;
use BackendMenu;
use Chkilel\Icones\Classes\Helpers;
use Chkilel\Icones\Models\Icon;
use Chkilel\Icones\Models\IconSet;
use System\Classes\SettingsManager;

class Settings extends Controller
{

    public $requiredPermissions = ['chkilel.icones.access_settings'];

    /**
     * Constructor.
     */
    public function __construct()
    {

        parent::__construct();

        $this->addCss('/modules/cms/assets/css/october.theme-selector.css', 'core');
        $this->addCss('/plugins/chkilel/icones/controllers/settings/assets/settings.css', 'Chkilel.Icones');

        $this->pageTitle = 'chkilel.icones::lang.settings.title';
        BackendMenu::setContext('October.System', 'system', 'settings');
        SettingsManager::setContext('Chkilel.Icones', 'settings');

        /*
         * Custom redirect for unauthorized request
         */
        $this->bindEvent('page.beforeDisplay', function () {
            if (!$this->user->hasAccess('chkilel.icones.access_settings')) {
                return Backend::redirect('backend/system/settings');
            }
        });
    }

    public function index()
    {

        $this->bodyClass = 'compact-container';
        $this->vars['iconSetsPaginator'] = $this->iconSetsPaginator(1);
    }

    /**
     * Handler for installing icon set
     * @return array|void
     * @throws \SystemException
     */
    public function index_onInstall()
    {
        $prefix = post('iconSet');

        $done = Helpers::installIconSet($prefix);

        if ($done) {
            $iconSet = IconSet::find($prefix);
            $iconSet->is_installed = true;
            $iconSet->is_enabled = true;
            $iconSet->save();
            \Flash::success(trans('chkilel.icones::lang.settings.flash_installed'));
            $this->vars['iconSetsPaginator'] = $this->iconSetsPaginator(1);
            return [
                '#icon-sets-list' => $this->makePartial('icon-sets_list')
            ];
        } else {
            \Flash::error(trans('chkilel.icones::lang.settings.flash_error_installation'));
        }
    }

    /**
     * @return array|void
     * @throws \SystemException
     */
    public function index_onDelete()
    {
        $prefix = post('iconSet');
        $deletedRows = Icon::where('icon_set_id', $prefix)->forceDelete();

        if ($deletedRows > 0) {
            $iconSet = IconSet::find($prefix);
            $iconSet->is_installed = false;
            $iconSet->save();

            $this->vars['iconSetsPaginator'] = $this->iconSetsPaginator(1);
            \Flash::success(trans('chkilel.icones::lang.settings.flash_deleted'));
            return [
                '#icon-sets-list' => $this->makePartial('icon-sets_list')
            ];
        } else {
            \Flash::error(trans('chkilel.icones::lang.settings.flash_error_deletion'));
        }
    }

    /**
     * @return array|void
     * @throws \SystemException
     */
    public function index_onEnable()
    {
        $prefix = post('iconSet');

        $restoredRows = Icon::withTrashed()
            ->where('icon_set_id', $prefix)
            ->restore();


        if ($restoredRows > 0) {
            $iconSet = IconSet::find($prefix);
            $iconSet->is_enabled = true;
            $iconSet->save();
            $this->vars['iconSetsPaginator'] = $this->iconSetsPaginator(1);
            \Flash::success(trans('chkilel.icones::lang.settings.flash_enabled'));
            return [
                '#icon-sets-list' => $this->makePartial('icon-sets_list')
            ];
        } else {
            \Flash::error(trans('chkilel.icones::lang.settings.flash_error_enabling'));
        }
    }

    /**
     * @return array|void
     * @throws \SystemException
     */
    public function index_onDisable()
    {
        $prefix = post('iconSet');

        $disabledRows = Icon::where('icon_set_id', $prefix)
            ->delete();

        if ($disabledRows > 0) {
            $iconSet = IconSet::find($prefix);
            $iconSet->is_enabled = false;
            $iconSet->save();
            $this->vars['iconSetsPaginator'] = $this->iconSetsPaginator(1);
            \Flash::success(trans('chkilel.icones::lang.settings.flash_disabled'));
            return [
                '#icon-sets-list' => $this->makePartial('icon-sets_list')
            ];
        } else {
            \Flash::error(trans('chkilel.icones::lang.settings.flash_error_disabling'));
        }
    }


    public function onPaginate()
    {
        $page = post('page');

        $this->vars['iconSetsPaginator'] = $this->iconSetsPaginator($page);
        return [
            '#icon-sets-list' => $this->makePartial('icon-sets_list')
        ];
    }


    public function iconSetsPaginator($page)
    {
        $query = IconSet::query();

        // If user doesn't have permission to install or delete icon sets,
        // We don't show him any of them
        if ($this->user->hasAccess('chkilel.icones.manage_installation')) {
            // Installed first in the listing page then those not yet installed
            $query->orderBy('is_installed', 'desc');
        } else {
            // Only installed in the listing page
            $query->where('is_installed', true);
        }

        // TODO paginate
        // Active ones first ordred by name
        $iconSetsPaginator = $query
            ->orderBy('is_enabled', 'desc')
            ->orderBy('name', 'asc')
            ->with('withTrashedIcons')
            ->paginate(10, ['*'], 'page', $page);

        $iconSetsPaginator = tap($iconSetsPaginator, function ($paginatedInstance) {

            return $paginatedInstance->getCollection()->transform(function ($value) {

                // If icon set not installed, we cannot get random icons from it
                if ($value->withTrashedIcons->count() > 0) {
                    $value->withTrashedIcons = $value->withTrashedIcons->random(9);
                }
                return $value;
            });
        });

        return $iconSetsPaginator;
    }
}
