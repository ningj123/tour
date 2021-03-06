<?php
namespace App\Models\Resources;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * 线路资源
 * @package App\Models
 */
class Fleet extends Model
{
    use SoftDeletes;


    protected $table = 'Resources_Fleet';//表名
    protected $primaryKey = "id";//主键


    protected $fillable = ['eid', 'name', 'linkman', 'mobile', 'tel', 'fax', 'abstract', 'createid', 'editid', 'sort', 'state'];
    protected $dates = ['deleted_at'];

    public function __construct()
    {

    }

    /**
     * The "booting" method of the model.
     *
     * @return void
     */
    public static function bootSoftDeletes()
    {
        parent::boot();
        static::addGlobalScope(new SoftDeletingScope());
    }

    /**
     * 获取应用到请求的验证规则
     *
     * @return array
     */
    public function createRules()
    {
        return [
            'name' => 'required|unique:Resources_Fleet|max:255|min:2',
        ];
    }

    /**
     * 获取应用到请求的验证规则
     *
     * @return array
     */
    public function editRules()
    {
        return [
            'name' => 'required|max:255|min:2',
        ];
    }

    /**
     * 获取应用到请求的验证规则
     *
     * @return array
     */
    public function messages()
    {
        return [
            'name.required' => '名称不能为空',
            'name.unique' => '名称不能相同',
        ];
    }


}
