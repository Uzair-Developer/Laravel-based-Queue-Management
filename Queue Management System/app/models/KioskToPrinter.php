<?php

class KioskToPrinter extends Eloquent
{
    protected $table = 'kiosk_to_printer';
    protected $guarded = array('');

    public static function add($inputs)
    {
        $inputs['create_timestamp'] = time();
        return self::create($inputs);
    }

    public static function edit($inputs, $id)
    {
        return self::where('id', $id)->update($inputs);
    }

    public static function getAll($inputs = '')
    {
        $data = self::whereRaw('1 = 1');
        if (isset($inputs['ip']) && $inputs['ip']) {
            $data = $data->where('ip', 'LIKE', '%' . $inputs['ip'] . '%');
        }
        if (isset($inputs['hospital_id']) && $inputs['hospital_id']) {
            $data = $data->where('hospital_id', $inputs['hospital_id']);
        }
        if (isset($inputs['get_by_hospital_id'])) {
            $data = $data->where('hospital_id', $inputs['get_by_hospital_id']);
        }
        if (isset($inputs['name']) && $inputs['name']) {
            $data = $data->whereRaw('LOWER(name) LIKE LOWER("%' . $inputs['name'] . '%")');
        }
        if (isset($inputs['printer_id']) && $inputs['printer_id']) {
            $data = $data->where('printer_id', $inputs['printer_id']);
        }
        if (isset($inputs['getFirst']) && $inputs['getFirst']) {
            $data = $data->first();
        } else {
            $data = $data->get();
        }
        if (isset($inputs['details']) && $inputs['details']) {
            foreach ($data as $key => $val) {
                $data[$key]['hospital_name'] = Hospital::getName($val['hospital_id']);
                $printer = IpToPrinter::getById($val['printer_id']);
                $data[$key]['printer_name'] = $printer['ip'] . ' [' . $printer['name'] . ']';
            }
        }
        return $data;
    }

    public static function getById($id)
    {
        return self::where('id', $id)->first();
    }

    public static function remove($id)
    {
        return self::where('id', $id)->delete();
    }

    public static function getNameById($id)
    {
        return self::where('id', $id)->pluck('name');
    }
}
