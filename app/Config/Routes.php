<?php

use CodeIgniter\Router\RouteCollection;

$routes->get('/', 'Auth::login');
$routes->get('/login', 'Auth::login');
$routes->post('/login', 'Auth::attemptLogin');
$routes->get('/logout', 'Auth::logout');

$routes->group('', ['filter' => 'auth'], function($routes) {
    $routes->get('/dashboard', 'Dashboard::index', ['filter' => 'fitur:23']);

    $routes->get('user', 'UserController::index', ['filter' => 'fitur:1']);
    $routes->get('user/create', 'UserController::create', ['filter' => 'fitur:2']);
    $routes->post('user/store', 'UserController::store', ['filter' => 'fitur:2']);
    $routes->get('user/edit/(:any)', 'UserController::edit/$1', ['filter' => 'fitur:3']);
    $routes->post('user/update/(:num)', 'UserController::update/$1', ['filter' => 'fitur:3']);
    $routes->get('user/delete/(:num)', 'UserController::delete/$1', ['filter' => 'fitur:4']);
    $routes->post('user/update-photo', 'UserController::updatePhoto');

    $routes->get('activity', 'Activity::index', ['filter' => 'fitur:13']);
    $routes->get('activity/create', 'Activity::create', ['filter' => 'fitur:14']);
    $routes->post('activity/store', 'Activity::store', ['filter' => 'fitur:14']);
    $routes->get('activity/edit/(:any)', 'Activity::edit/$1', ['filter' => 'fitur:15']);
    $routes->post('activity/update/(:num)', 'Activity::update/$1', ['filter' => 'fitur:15']);
    $routes->get('activity/delete/(:num)', 'Activity::delete/$1', ['filter' => 'fitur:16']);

    $routes->get('project', 'Project::index', ['filter' => 'fitur:5']);
    $routes->get('project/create', 'Project::create', ['filter' => 'fitur:6']);
    $routes->post('project/store', 'Project::store', ['filter' => 'fitur:6']);
    $routes->get('project/edit/(:any)', 'Project::edit/$1', ['filter' => 'fitur:7']);
    $routes->post('project/update/(:num)', 'Project::update/$1', ['filter' => 'fitur:7']);
    $routes->get('project/delete/(:num)', 'Project::delete/$1', ['filter' => 'fitur:8']);

    $routes->get('role', 'Roles::index', ['filter' => 'fitur:9']);
    $routes->get('role/create', 'Roles::create', ['filter' => 'fitur:10']);
    $routes->post('role/store', 'Roles::store', ['filter' => 'fitur:10']);
    $routes->get('role/edit/(:any)', 'Roles::edit/$1', ['filter' => 'fitur:11']);
    $routes->post('role/update/(:num)', 'Roles::update/$1', ['filter' => 'fitur:11']);
    $routes->get('role/delete/(:num)', 'Roles::delete/$1', ['filter' => 'fitur:12']);

    $routes->get('/tryout', 'Tryout::index');
    $routes->get('/tryout/jig', 'Tryout::index/jig');
    $routes->get('/tryout/create', 'Tryout::create');
    $routes->post('/tryout/store', 'Tryout::store');
    $routes->get('/tryout/show/(:num)', 'Tryout::show/$1');
    $routes->get('tryout/edit/(:num)', 'Tryout::edit/$1');
    $routes->post('tryout/update/(:num)', 'Tryout::update/$1');
    $routes->get('/tryout/print/(:num)', 'Tryout::exportPdf/$1');
    $routes->get('tryout/delete/(:num)', 'Tryout::delete/$1');
    
    $routes->get('tryout-jig', 'TryoutJig::index');
    $routes->get('tryout-jig/create', 'TryoutJig::create');
    $routes->post('tryout-jig/store', 'TryoutJig::store');
    $routes->get('tryout-jig/edit/(:num)', 'TryoutJig::edit/$1');
    $routes->post('tryout-jig/update/(:num)', 'TryoutJig::update/$1');
    $routes->get('tryout-jig/show/(:num)', 'TryoutJig::show/$1');
    $routes->get('tryout-jig/delete/(:num)', 'TryoutJig::delete/$1');
    $routes->get('tryout-jig/print/(:num)', 'TryoutJig::print/$1');
    $routes->get('tryout-jig/exportPdf/(:num)', 'TryoutJig::exportPdf/$1');
    
    $routes->group('actual-activity', function($routes) {
        $routes->get('/', 'ActualActivity::index', ['filter' => 'fitur:17']);
        $routes->get('personal', 'ActualActivity::indexPersonal', ['filter' => 'fitur:19']);
        $routes->get('create', 'ActualActivity::create', ['filter' => 'fitur:20']);
        $routes->post('store', 'ActualActivity::store', ['filter' => 'fitur:20']);
        $routes->get('edit/(:any)', 'ActualActivity::edit/$1', ['filter' => 'fitur:21']);
        $routes->post('update/(:any)', 'ActualActivity::update/$1', ['filter' => 'fitur:21']);
        $routes->get('delete/(:any)', 'ActualActivity::delete/$1', ['filter' => 'fitur:18']);
        $routes->post('detail/delete', 'ActualActivity::deleteDetail');
        $routes->get('submit/(:any)', 'ActualActivity::submit/$1', ['filter' => 'fitur:27']);
        $routes->get('rollback/(:any)', 'ActualActivity::rollback/$1');
        $routes->get('detail/(:any)', 'ActualActivity::detail/$1', ['filter' => 'fitur:22']);
    });
    $routes->post('detail/delete', 'ActualActivity::deleteDetail');
    $routes->get('actual-activity/fetchActivities', 'ActualActivity::fetchActivities');
    $routes->get('actual-activity/fetchModels', 'ActualActivity::fetchModels');
    $routes->get('actual-activity/fetchPartNoProcess', 'ActualActivity::fetchPartNoProcess');
    $routes->post('actual-activity/export-excel', 'ActualActivity::exportExcel');
 
    $routes->get('history', 'History::index', ['filter' => 'fitur:24']);
    $routes->get('history-monthly', 'History::indexMonthly', ['filter' => 'fitur:24']);
    $routes->get('profile', 'History::profile', ['filter' => 'fitur:25']);
    $routes->get('history/detail/(:any)', 'History::detailProfil/$1', ['filter' => 'fitur:26']);

    $routes->group('auth', function($routes) {
        $routes->get('reset/(:any)', 'Auth::reset/$1');
        $routes->post('reset/(:any)', 'Auth::updatePassword/$1');
    });
    $routes->group('history', function($routes) {
        $routes->get('create', 'History::create');
        $routes->post('store', 'History::store');
    });
 

    $routes->post('pps/fetchMachine', 'Pps::fetchMachine');
    $routes->group('holiday', function($routes) {
        $routes->get('/', 'HolidayController::index');
        
        $routes->get('create', 'HolidayController::create');
        
        $routes->post('store', 'HolidayController::store');
        
        $routes->get('delete/(:num)', 'HolidayController::delete/$1');
    });
    $routes->get('izin', 'IzinController::index');
    $routes->get('izin/delete/(:num)', 'IzinController::delete/$1');
    $routes->get('izin/create', 'IzinController::create');
    $routes->post('izin/store', 'IzinController::store');

    $routes->group('outdoor-activity', ['namespace' => 'App\Controllers'], function($routes) {
        $routes->get('/', 'OutdoorActivity::index');
        $routes->get('display', 'OutdoorActivity::display');
        $routes->get('create', 'OutdoorActivity::create');
        $routes->post('store', 'OutdoorActivity::store');
        $routes->get('edit/(:num)', 'OutdoorActivity::edit/$1');
        $routes->post('update/(:num)', 'OutdoorActivity::update/$1');
        $routes->get('delete/(:num)', 'OutdoorActivity::delete/$1');
    });
 
        
    $routes->get('excel', 'ExcelController::index');
    $routes->get('user/downloadExcel', 'UserController::downloadExcel');

    $routes->post('/upload-excel', 'ExcelController::upload');
    $routes->get('dashboard/projectDetail/(:any)', 'Dashboard::projectDetail/$1');
    $routes->group('finishing',  function($routes) {
        $routes->get('', 'FinishingController::index');
        $routes->get('create', 'FinishingController::create' );
        $routes->post('store', 'FinishingController::store' );
        $routes->get('edit/(:any)', 'FinishingController::edit/$1');
        $routes->post('update/(:num)', 'FinishingController::update/$1');
        $routes->post('delete/(:num)', 'FinishingController::delete/$1');

    });
    $routes->group('cuttingtools',  function($routes) {
        $routes->get('/', 'CuttingToolController::index');
        $routes->get('create', 'CuttingToolController::create');
        $routes->post('store', 'CuttingToolController::store');
        $routes->get('edit/(:any)', 'CuttingToolController::edit/$1');
        $routes->post('update/(:num)', 'CuttingToolController::update/$1');
        $routes->post('delete/(:num)', 'CuttingToolController::delete/$1');
    });
    $routes->group('leadtime',  function($routes) {
    $routes->get('/', 'LeadTimeController::index');
        $routes->get('create', 'LeadTimeController::create');
        $routes->post('store', 'LeadTimeController::store');
        $routes->get('edit/(:any)', 'LeadTimeController::edit/$1');
        $routes->post('update/(:num)', 'LeadTimeController::update/$1');
        $routes->post('delete/(:num)', 'LeadTimeController::delete/$1');
    });
    $routes->get('pps/create', 'Pps::create');
    $routes->get('pps', 'Pps::index'); 
    $routes->post('pps/submit', 'Pps::submitandDownload');
    $routes->post('pps/fetchMachineByMachine', 'Pps::fetchMachineByMachine');
    $routes->post('pps/fetchStandard', 'Pps::fetchStandard');
    $routes->get('pps/downloadTemplate', 'PpsController::downloadTemplate');
    $routes->post('pps/fetchNewMasterData', 'Pps::fetchNewMasterData');
    $routes->get('/pps/edit/(:num)', 'Pps::edit/$1');
    $routes->get('/pps/editNew/(:num)', 'Pps::edit/$1/copy');
    $routes->get('pps/logAktivitas', 'Pps::logAktivitas');
    $routes->get('/pps/delete/(:num)', 'Pps::delete/$1');
    $routes->get('/pps/rollback/(:num)', 'Pps::rollback/$1');
    $routes->get('pps/list-process-dies/(:any)', 'Pps::listProcessDies/$1');
    $routes->get('pps/generate/(:num)', 'Pps::generateExcel/$1');
    $routes->post('pps/update/', 'Pps::update/');
    $routes->get('pps/detail/(:num)', 'Pps::detail/$1'); 
    $routes->get('dcp', 'Dcp::index'); 
    $routes->get('dcp/create/(:any)', 'Dcp::create/$1');
    $routes->post('dcp/store', 'Dcp::store');
    $routes->get('dcp/edit/(:num)', 'Dcp::edit/$1');
    $routes->post('dcp/update/(:any)', 'Dcp::update/$1');
    $routes->get('dcp/delete/(:any)', 'Dcp::delete/$1');

    $routes->get('dcp/nextprocess/(:any)', 'Dcp::nextProcess/$1');
    $routes->post('dcp/convert', 'Dcp::convertDcp');
    $routes->get('dcp-excel/(:any)', 'Dcp::generateExcel/$1');
    $routes->get('calendar/', 'History::calendar');

    // $routes->get('master-pps/master-spec-mc', 'MasterPps::spec_mc');
    $routes->post('/machine-match/checkMatch', 'Pps::checkMatch');

    // $routes->get('master-pps/standard-die-design/', 'MasterPps::standard_die_design');
    $routes->get('master-pps/', 'MasterPps::index');
    $routes->get('Pps/listPpsImages', 'Pps::listPpsImages');
    $routes->get('Pps/listPpsImages3', 'Pps::listPpsImages3');
    $routes->get('Pps/listDieConsImg', 'Pps::listDieConsImg');
    $routes->get('get-sp-material-spec', 'Dcp::getSpMaterialSpec');
    $routes->get('get-sp-material-spec-2', 'Dcp::getSpMaterialSpec-2');


    $routes->get('/calendar/events', 'History::getCalendarEvents');

    $routes->get('/calendar/events', 'Calendar::events');
    $routes->post('/calendar/add', 'Calendar::add');
    $routes->delete('/calendar/delete/(:num)', 'Calendar::delete/$1');


    $routes->get('/material', 'MaterialController::index');
    $routes->get('/material/create', 'MaterialController::create');
    $routes->post('/material/store', 'MaterialController::store');
    $routes->get('/material/edit/(:num)', 'MaterialController::edit/$1');
    $routes->post('/material/update/(:num)', 'MaterialController::update/$1');
    $routes->get('/material/delete/(:num)', 'MaterialController::delete/$1');

    $routes->get('/mc-spec/create', 'MasterPps::create');
    $routes->post('/mc-spec/store', 'MasterPps::store');
    $routes->get('/mc-spec/edit/(:num)', 'MasterPps::edit/$1');
    $routes->post('/mc-spec/update/(:num)', 'MasterPps::update/$1');
    $routes->get('/mc-spec/delete/(:num)', 'MasterPps::delete/$1');
    $routes->get('die-cons', 'DieConsController::index');  
    $routes->get('die-cons/new', 'DieConsController::new');  
    $routes->post('die-cons', 'DieConsController::create');  
    $routes->get('die-cons/(:num)', 'DieConsController::show/$1');  
    $routes->get('die-cons/(:num)/edit', 'DieConsController::edit/$1');  
    $routes->put('die-cons/(:num)', 'DieConsController::update/$1');  
    $routes->delete('die-cons/(:num)', 'DieConsController::delete/$1');  


    $routes->get('ccf', 'Ccf::index'); 
    $routes->get('ccf/create', 'Ccf::create/');
    $routes->post('ccf/store', 'Ccf::store');
    $routes->get('ccf/edit/(:num)', 'Ccf::edit/$1');
    $routes->post('ccf/update/(:any)', 'Ccf::update/$1');
    $routes->get('ccf/delete/(:any)', 'Ccf::delete/$1');
    $routes->get('ccf/nextprocess/(:any)', 'Ccf::nextProcess/$1');
    $routes->get('ccf/export/(:any)', 'Ccf::generateExcel/$1');
    $routes->get('/ccf/rollback/(:num)', 'Ccf::rollback/$1');
    $routes->get('ccf/lead-time/(:any)', 'Ccf::getLeadTime/$1');
    $routes->get('/ccf/editNew/(:num)', 'Ccf::edit/$1/copy');

    $routes->get('jcp', 'Jcp::index'); 
    $routes->get('jcp/create', 'Jcp::create/');
    $routes->post('jcp/store', 'Jcp::store');
    $routes->get('jcp/edit/(:num)', 'Jcp::edit/$1');
    $routes->post('jcp/update/(:any)', 'Jcp::update/$1');
    $routes->get('jcp/delete/(:any)', 'Jcp::delete/$1');
    $routes->get('jcp/nextprocess/(:any)', 'Jcp::nextProcess/$1');
    $routes->get('jcp/export/(:any)', 'Jcp::generateExcel/$1');
    $routes->get('/jcp/rollback/(:num)', 'Jcp::rollback/$1');
    $routes->get('jcp/lead-time/(:segment)', 'Jcp::leadTime/$1');

    $routes->get('/jcp/editNew/(:num)', 'Jcp::edit/$1/copy');

    $routes->group('ccf-master-leadtime', ['namespace' => 'App\Controllers'], function($routes){
    
        $routes->get('', 'CcfLeadTimeController::index', ['as' => 'ccf-master-leadtime.index']);

        $routes->get('create', 'CcfLeadTimeController::create', ['as' => 'ccf-master-leadtime.create']);
    
        $routes->post('store', 'CcfLeadTimeController::store', ['as' => 'ccf-master-leadtime.store']);
    
        $routes->get('edit/(:num)', 'CcfLeadTimeController::edit/$1', ['as' => 'ccf-master-leadtime.edit']);
    
        $routes->post('update/(:num)', 'CcfLeadTimeController::update/$1', ['as' => 'ccf-master-leadtime.update']);

        $routes->post('delete/(:num)', 'CcfLeadTimeController::delete/$1', ['as' => 'ccf-master-leadtime.delete']);
    });
    $routes->group('ccf-master-main-material', ['namespace'=>'App\Controllers'], function($r){
        $r->get('/',               'CcfMasterMainMaterial::index');
        $r->get('create',          'CcfMasterMainMaterial::create');
        $r->post('store',          'CcfMasterMainMaterial::store');
        $r->get('edit/(:num)',     'CcfMasterMainMaterial::edit/$1');
        $r->post('update/(:num)',  'CcfMasterMainMaterial::update/$1');
        $r->get('delete/(:num)',   'CcfMasterMainMaterial::delete/$1');
    });

      $routes->group('ccf-master-tool-cost', ['namespace'=>'App\Controllers'], function($r){
        $r->get('/',               'CcfMasterToolCost::index');
        $r->get('create',          'CcfMasterToolCost::create');
        $r->post('store',          'CcfMasterToolCost::store');
        $r->get('edit/(:num)',     'CcfMasterToolCost::edit/$1');
        $r->post('update/(:num)',  'CcfMasterToolCost::update/$1');
        $r->get('delete/(:num)',   'CcfMasterToolCost::delete/$1');
    });

    $routes->get('ccf-master-standard-part', 'CcfMasterStandardPart::index');
    $routes->get('ccf-master-standard-part/create', 'CcfMasterStandardPart::create');
    $routes->post('ccf-master-standard-part/store', 'CcfMasterStandardPart::store');
    $routes->get('ccf-master-standard-part/edit/(:num)', 'CcfMasterStandardPart::edit/$1');
    $routes->post('ccf-master-standard-part/update/(:num)', 'CcfMasterStandardPart::update/$1');
    $routes->get('ccf-master-standard-part/delete/(:num)', 'CcfMasterStandardPart::delete/$1');
    $routes->get('assistant', 'AiAsssitantController::index');
    $routes->post('assistant/generate', 'AiAsssitantController::generate');
    $routes->post('assistant/chat', 'AiAsssitantController::chat');

    $routes->get('ppsAssistant', 'PpsAssistantController::index');
    $routes->post('ppsAssistant/generate', 'PpsAssistantController::generate');
    $routes->post('ppsAssistant/chat', 'PpsAssistantController::chat');
    $routes->get('pps/analisa', 'Pps::analisa');
    $routes->post('pps/analisa', 'Pps::analisa');
    $routes->post('pps/exportAnalisa', 'Pps::exportAnalisa');

    $routes->group('piket', function($routes) {
        $routes->get('/', 'PiketController::index');
        $routes->get('atur', 'PiketController::atur');
        $routes->post('simpan', 'PiketController::simpan');
        $routes->post('hapus', 'PiketController::hapus');
        $routes->get('acak', 'PiketController::acak');
    });
    $routes->get('piket/kirim-jadwal-hari-ini', 'PiketController::kirimPersentaseLKH');

    
    $routes->group('briefing', ['namespace' => 'App\Controllers'], function($routes) {
        $routes->get('/', 'BriefingController::index');
        $routes->get('calendar', 'BriefingController::calendar');
        $routes->get('user-schedule/(:num)', 'BriefingController::getUserSchedule/$1');
        $routes->get('events', 'BriefingController::getEvents');
        $routes->get('schedule-detail', 'BriefingController::getScheduleDetail');
        $routes->get('holidays', 'BriefingController::getHolidays');
        $routes->get('export', 'BriefingController::exportSchedule');
        $routes->get('debug', 'BriefingController::debugEvents');

        $routes->post('update-order', 'BriefingController::updateOrder');
        $routes->post('add-leader', 'BriefingController::addLeader');
        $routes->post('mark-absent', 'BriefingController::markAbsent');
        $routes->post('generate-schedule', 'BriefingController::generateUpcomingSchedule');
        
        $routes->delete('remove-leader/(:num)', 'BriefingController::removeLeader/$1');
        $routes->delete('delete-schedule', 'BriefingController::deleteSchedule');
        
    });

    $routes->group('jcp-master-leadtime', ['namespace' => 'App\Controllers'], function($r) {
    $r->get('/',               'JcpLeadtime::index');
    $r->get('create',          'JcpLeadtime::create');
    $r->post('store',          'JcpLeadtime::store');
    $r->get('edit/(:num)',     'JcpLeadtime::edit/$1');
    $r->post('update/(:num)',  'JcpLeadtime::update/$1');
    $r->get('delete/(:num)',   'JcpLeadtime::delete/$1');
});

});
