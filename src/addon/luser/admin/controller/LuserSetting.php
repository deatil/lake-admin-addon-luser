<?php

namespace app\admin\controller;

use think\facade\Cache;

use app\luser\model\Config as ConfigModel;

/**
 * 设置
 *
 * @create 2020-8-23
 * @author deatil
 */
class LuserSetting extends LuserBase
{
    /**
     * 设置
     *
     * @create 2020-8-14
     * @author deatil
     */
    public function index()
    {
        if ($this->request->isPost()) {
            $data = $this->request->post();

            if (!empty($data)) {
                foreach ($data as $key => $item) {
                    ConfigModel::where([
                        'name' => $key,
                    ])->update([
                        'value' => $item,
                    ]);
                }
            }
            
            Cache::delete("luser_config");
            
            return $this->success('设置更新成功');
        } else {
            $config = ConfigModel::column('name,value');
            
            $setting = [];
            if (!empty($config)) {
                foreach ($config as $val) {
                    $setting[$val['name']] = $val['value'];
                }
            }
                
            $this->assign('setting', $setting);

            return $this->fetch();
        }

    }
    
}
