<?php

namespace Lib\core;

class globalTools
{ 
    public function renderList($data, $name, $selected, $blank = true, $id = NULL) { 
        if($id){
            $html = '<select class="form-control" id="'.$id.'" name="' . $name . '">';
        }else{
            $html = '<select class="form-control" name="' . $name . '">';
        }
        if ($blank) {
            $html .= '<option value="">' . trans('say.-- Pilih --') . '</option>';
        }
        foreach ($data as $row) {
            if (is_array($selected)) {
                if (in_array($row->id, $selected)) {
                    $select = 'selected';
                } else {
                    $select = '';
                }
            } else {
                if ($selected == $row->id) {
                    $select = 'selected';
                } else {
                    $select = '';
                }
            }

            $html .= '<option value="' . $row->id . '" ' . $select . '>' . $row->name . '</option>';
        }
        $html .= '</select>';
        return $html;
    }

    public function renderListWithCode($data, $name, $selected, $blank = true)
    {
        $html = '<select class="form-control" name="' . $name . '">';
        if ($blank) {
            $html .= '<option value="">' . trans('say.-- Pilih --') . '</option>';
        }
        foreach ($data as $row) {
            if ($selected == $row->id) {
                $select = 'selected';
            } else {
                $select = '';
            }
            $html .= '<option value="' . $row->id . '" ' . $select . '>' . $row->code . ' - ' . $row->name . '</option>';
        }
        $html .= '</select>';
        return $html;
    }

    public function renderListArray($data, $name, $selected, $blank = true)
    {
        $html = '<select class="form-control" name="' . $name . '">';
        if ($blank) {
            $html .= '<option value="">' . trans('say.-- Pilih --') . '</option>';
        }
        foreach ($data as $key => $row) {
            if (is_array($selected)) {
                if (in_array($key, $selected)) {
                    $select = 'selected';
                } else {
                    $select = '';
                }
            } else {
                if ($selected == $key) {
                    $select = 'selected';
                } else {
                    $select = '';
                }
            }
            $html .= '<option value="' . $key . '" ' . $select . '>' . $row . '</option>';
        }
        $html .= '</select>';
        return $html;
    }

    public function renderListNested($list = [], $name, $selected = null, $blank = true, $options = [], $disabled = [])
    {
        $html = '<select class="form-control" name="' . $name . '">';
        if ($blank) {
            $html .= '<option value="">' . trans('say.-- Pilih --') . '</option>';
        }
        foreach ($options as $attribute => $value) {
            $html .= ' ' . $attribute . '="' . $value . '"';
        }
        $html .= '">';
        foreach ($list as $value => $text) {
            $html .= '<option value="' . $value . '"' . ($value == $selected ? ' selected="selected"' : '') . (in_array($value, $disabled) ? ' disabled="disabled"' : '') . '>' .
                $text . '</option>';
        }
        $html .= '</select>';
        return $html;
    }

    function randomString()
    {
        $length = 6;
        $characters = '0123456789abcdefghijklmnopqrstuvwxyz';
        $string = '';
        for ($p = 0; $p < $length; $p++) {
            $string .= $characters[mt_rand(0, strlen($characters) - 1)];
        }
        return $string;
    }

    public function generatePoCode($type)
    {
        //000001/PO/XI/2008
        $codes = \Models\ng_purchase_order::select('code')->get();
        $sequence = '000001';

        if ($codes) {
            $expl_codes = array();
            foreach ($codes as $code) {
                $expl_codes[] = substr($code->code, 0, 6);
            }
            if (!$expl_codes) {
                $max = 0;
            } else {
                $max = max($expl_codes);
            }
            $sequence = $seq = sprintf('%06s', $max + 1);
        }

        return $sequence . '/' . $type . '/' . $this->monthToRoman() . '/' . date('Y');
    }

    function monthToRoman()
    {
        $month = date('n');

        switch ($month) {
            case '1':
                $no = 'I';
                break;
            case '2':
                $no = 'II';
                break;
            case '3':
                $no = 'III';
                break;
            case '4':
                $no = 'IV';
                break;
            case '5':
                $no = 'V';
                break;
            case '6':
                $no = 'VI';
                break;
            case '7':
                $no = 'VII';
                break;
            case '8':
                $no = 'VIII';
                break;
            case '9':
                $no = 'IX';
                break;
            case '10':
                $no = 'X';
                break;
            case '11':
                $no = 'XI';
                break;
            default:
                $no = 'XII';
                break;
                break;
        }
        return $no;
    }

    public static function is_valid_email($email)
    {
        return filter_var($email, FILTER_VALIDATE_EMAIL);
    }

    public static function is_valid_cellphone($phone)
    {
        /*
         * 
          telkomsel.regex = ^(\\+62|\\+0|0|62)8(1[123]|52|53|21|22|23)[0-9]{5,9}$
          simpati.regex = ^(\\+62|\\+0|0|62)8(1[123]|2[12])[0-9]{5,9}$
          as.regex = ^(\\+62|\\+0|0|62)8(52|53|23)[0-9]{5,9}$
          indosat.regex= ^(\\+62815|0815|62815|\\+0815|\\+62816|0816|62816|\\+0816|\\+62858|0858|62858|\\+0814|\\+62814|0814|62814|\\+0814)[0-9]{5,9}$
          im3.regex = ^(\\+62855|0855|62855|\\+0855|\\+62856|0856|62856|\\+0856|\\+62857|0857|62857|\\+0857)[0-9]{5,9}$
          xl.regex = ^(\\+62817|0817|62817|\\+0817|\\+62818|0818|62818|\\+0818|\\+62819|0819|62819|\\+0819|\\+62859|0859|62859|\\+0859|\\+0878|\\+62878|0878|62878|\\+0877|\\+62877|0877|62877)[0-9]{5,9}$
          smart.regex = ^(\\+62|\\+0|0|62)8(81|87)[0-9]{5,9}$
          fren.regex = ^(\\+62|\\+0|0|62)8(88|89)[0-9]{5,9}$
          tri.regex = ^(\\+62|\\+0|0|62)8(98|99)[0-9]{5,9}$
          BYRU.regex = ^(\\+62|\\+0|0|62)8(68)[0-9]{5,9}$

         */

        if (preg_match("/^(\\+62|\\+0|0|62)8(1[123]|52|53|21|22|23)[0-9]{5,9}$/", $phone)) {
            return true;
        } else if (preg_match("/^(\\+62|\\+0|0|62)8(1[123]|2[12])[0-9]{5,9}$/", $phone)) {
            return true;
        } else if (preg_match("/^(\\+62|\\+0|0|62)8(52|53|23)[0-9]{5,9}$/", $phone)) {
            return true;
        } else if (preg_match("/^(\\+62815|0815|62815|\\+0815|\\+62816|0816|62816|\\+0816|\\+62858|0858|62858|\\+0814|\\+62814|0814|62814|\\+0814)[0-9]{5,9}$/", $phone)) {
            return true;
        } else if (preg_match("/^(\\+62855|0855|62855|\\+0855|\\+62856|0856|62856|\\+0856|\\+62857|0857|62857|\\+0857)[0-9]{5,9}$/", $phone)) {
            return true;
        } else if (preg_match("/^(\\+62817|0817|62817|\\+0817|\\+62818|0818|62818|\\+0818|\\+62819|0819|62819|\\+0819|\\+62859|0859|62859|\\+0859|\\+0878|\\+62878|0878|62878|\\+0877|\\+62877|0877|62877)[0-9]{5,9}$/", $phone)) {
            return true;
        } else if (preg_match("/^(\\+62|\\+0|0|62)8(81|87)[0-9]{5,9}$/", $phone)) {
            return true;
        } else if (preg_match("/^(\\+62|\\+0|0|62)8(88|89)[0-9]{5,9}$/", $phone)) {
            return true;
        } else if (preg_match("/^(\\+62|\\+0|0|62)8(98|99)[0-9]{5,9}$/", $phone)) {
            return true;
        } else if (preg_match("/^(\\+62|\\+0|0|62)8(68)[0-9]{5,9}$/", $phone)) {
            return true;
        } else {
            return false;
        }
    }

    public static function has_task($code, $dept = false, $acl = true, $class = false, $class_ids = [], $student = false, $student_ids = [])
    {
        $akses = false;
        $akses_dept = true;
        $akses_class = true;
        $akses_acl = true;
        $akses_student = true;

        if ($acl) {
            $akses_acl = false;
            $task_acl = \Models\task::whereHas('task_acl', function ($builder) {
                $builder->where('groups_id', Session()->get('group_as', ''));
            })
                ->where('code', $code)
                ->get();

            if (count($task_acl) > 0) {
                $akses_acl = true;
            }
        }

        if ($dept) {
            $akses_dept = false;
            $task_dept = \Models\task::whereHas('task_department', function ($builder) {
                $builder->whereIn('ng_department_id', Session()->get('ng_department_ids', ''));
            })
                ->where('code', $code)
                ->get();

            if (count($task_dept) > 0) {
                $akses_dept = true;
            }
        }

        if ($class) {
            $akses_class = false;
            $task_class = \Models\task::whereHas('task_class_level', function ($builder) use ($class_ids) {
                $builder->whereIn('ng_class_level_id', $class_ids);
            })
                ->where('code', $code)
                ->get();

            if (count($task_class) > 0) {
                $akses_class = true;
            }
        }

        if ($student) {
            $akses_student = false;
            $task_student = \Models\task::whereHas('task_student', function ($builder) use ($student_ids) {
                $builder->whereIn('ng_student_id', $student_ids);
            })
                ->where('code', $code)
                ->get();

            if (count($task_student) > 0) {
                $akses_student = true;
            }
        }

        if ($akses_acl && $akses_dept && $akses_class && $akses_student) {
            $akses = true;
        }

        return $akses;
    }

    public static function has_task_by_param($code, $dept = false, $acl = true, $class = false, $groups_id = '', $ng_department_id = '', $ng_class_level_id = '', $job = false, $job_id = '')
    {
        $akses = false;
        $akses_dept = true;
        $akses_class = true;
        $akses_acl = true;
        $akses_job = true;

        if ($acl) {
            $akses_acl = false;
            $task_acl = \Models\task::whereHas('task_acl', function ($builder) use ($groups_id) {
                $builder->where('groups_id', $groups_id);
            })
                ->where('code', $code)
                ->get();

            if (count($task_acl) > 0) {
                $akses_acl = true;
            }
        }

        if ($dept) {
            $akses_dept = false;
            $task_dept = \Models\task::whereHas('task_department', function ($builder) use ($ng_department_id) {
                $builder->where('ng_department_id', $ng_department_id);
            })
                ->where('code', $code)
                ->get();

            if (count($task_dept) > 0) {
                $akses_dept = true;
            }
        }

        if ($class) {
            $akses_class = false;
            $task_class = \Models\task::whereHas('task_class_level', function ($builder) use ($ng_class_level_id) {
                $builder->whereIn('ng_class_level_id', $ng_class_level_id);
            })
                ->where('code', $code)
                ->get();

            if (count($task_class) > 0) {
                $akses_class = true;
            }
        }

        if ($job) {
            $akses_job = false;
            $task_job = \Models\task::whereHas('task_job', function ($builder) use ($job_id) {
                $builder->where('job_id', $job_id);
            })
                ->where('code', $code)
                ->get();
            if (count($task_job) > 0) {
                $akses_job = true;
            }
        }

        if ($akses_acl && $akses_dept && $akses_class && $akses_job) {
            $akses = true;
        }

        return $akses;
    }
}
