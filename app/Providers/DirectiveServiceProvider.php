<?php

namespace App\Providers;

use Illuminate\Routing\UrlGenerator;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\Facades\Auth;
use Form;

class DirectiveServiceProvider extends ServiceProvider
{

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Blade::directive('selectNestedAcademic', function () {
            return Form::nestedSelect('ng_academic_calendar_id', (['' => say('-- Pilih --')] + \Models\ng_academic_calendar::nestedSelect()), null, array('class' => 'form-control selectpicker', 'data-live-search' => 'true', 'id' => 'ng_academic_calendar_id'), \Models\ng_academic_calendar::getAllParents());
        });

        Blade::directive('selectAcademic', function () {
            return Form::select('ng_academic_calendar_id', (['' => say('-- Pilih --')] + \Models\ng_academic_calendar::nestedSelect()), null, array('class' => 'form-control selectpicker', 'data-live-search' => 'true', 'id' => 'ng_academic_calendar_id'), \Models\ng_academic_calendar::getAllParents());
        });
        Blade::directive('selectNestedDepartment', function () {
            return Form::nestedSelect('ng_department_id', (['' => say('-- Pilih --')] + \Models\ng_department::nestedSelect()), null, array('class' => 'form-control selectpicker', 'data-live-search' => 'true', 'id' => 'ng_department_id'), \Models\ng_department::getAllParents());
        });

        Blade::directive('searchDepartment', function () {
            return Form::nestedSelect('filter[ng_department_id]', (['' => say('-- Pilih --')] + \Models\ng_department::nestedSelect()), null, array('class' => 'form-control selectpicker', 'data-live-search' => 'true', 'id' => 'ng_department_id'), \Models\ng_department::getAllParents());
        });

        Blade::directive('selectMonths', function () {
            return Form::selectMonths('month', null, date('m'), array('class' => 'form-control selectpicker', 'data-live-search' => 'true', 'id' => 'month'));
        });

        Blade::directive('selectYears', function () {
            return Form::selectYears('year', null, date('Y'), array('class' => 'form-control selectpicker', 'data-live-search' => 'true', 'id' => 'year'));
        });

        Blade::directive('selectDate', function () {
            return Form::selectDate('date', null, 3, array('class' => 'form-control selectpicker', 'data-live-search' => 'true', 'id' => 'date'));
        });

        Blade::directive('selectHours', function () {
            return Form::selectHours('hour', null, null, array('class' => 'form-control selectpicker', 'data-live-search' => 'true', 'id' => 'date'));
        });

        Form::macro('selectMonths', function ($name, $data = NULL, $default = NULL, $options = array(), $format = '%B') {
            $months = [];
            $bulan = array(
                1 => say("Januari"),
                2 => say("Februari"),
                3 => say("Maret"),
                4 => say("April"),
                5 => say("Mei"),
                6 => say("Juni"),
                7 => say("Juli"),
                8 => say("Agustus"),
                9 => say("September"),
                10 => say("Oktober"),
                11 => say("November"),
                12 => say("Desember")
            );

            if (array_key_exists('empty', $options)) {
                if ($options['empty']) {
                    $bulan = array_merge([NULL => say("Select Month")], $bulan);
                }
            }

            if (array_key_exists('custom-range', $options)) {
                if (array_key_exists('custom-range', $options)) {
                    $start = explode("-", $options['custom-range'])[0];
                    $end = explode("-", $options['custom-range'])[1];
                }
                $bulan = array_intersect_key($bulan, array_flip(range($start, $end)));
            }
            foreach ($bulan as $k => $month) {
                $months[$k] = $month;
            }
            return Form::select($name, $months, $default, $options);
        });

        Form::macro('selectYears', function ($name, $data = [], $default = NULL, $options = array(), $format = '%B') {
            if (!$data) {
                $data[NULL] = say("Pilih Tahun");
                $start = 2017;
                $end = (date('Y') + 5);
                if (array_key_exists('custom-range', $options)) {
                    $start = explode("-", $options['custom-range'])[0];
                    $end = explode("-", $options['custom-range'])[1];
                }
                foreach (range($start, $end) as $year) {
                    $data[$year] = $year;
                }
            }
            return Form::select($name, $data, $default, $options);
        });

        Form::macro('selectDate', function ($name, $data = NULL, $default = NULL, $options = array(), $format = '%B') {
            $date_periods = [];
            foreach (range(1, 31) as $v) {
                $date_periods[$v] = $v;
            }
            return Form::select($name, $date_periods, $default, $options);
        });

        Form::macro('sequences', function ($name, $data = NULL, $default = NULL, $options = array(), $format = '%B') {
            $sequences = [];
            foreach (range(1, 12) as $v) {
                $sequences[$v] = $v;
            }
            return Form::select($name, $sequences, $default, $options);
        });

        Form::macro('selectHours', function ($name, $data = NULL, $default = NULL, $options = array(), $format = '%B') {
            if (!$data) {
                foreach (range(1, 24) as $v) {
                    $data[sprintf('%02s', $v)] = sprintf('%02s', $v) . ':00';
                }
            }
            return Form::select($name, $data, $default, $options);
        });
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    public function numberToMonth($no)
    {
        $bulan = array(
            "", say("Januari"), say("Februari"), say("Maret"), say("April"), say("Mei"), say("Juni"), say("Juli"), say("Agustus"), say("September"), say("Oktober"), say("November"), say("Desember")
        );
        $result = $bulan[$no];
        return $result;
    }
}
