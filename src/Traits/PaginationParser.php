<?php
/**
 * Created by PhpStorm.
 * User: dongyuxiang
 * Date: 15/01/2018
 * Time: 16:44
 */

namespace Dongm2ez\Db\Traits;


use Dongm2ez\Db\Constant\Query;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

trait PaginationParser
{
    /**
     * 分页配置
     * @param array ...$args
     * @return array
     */
    public function paginationConfigure(...$args): array
    {
        $condition = $args[0] ?? [];
        $total = $args[1] ?? 0;

        $extends = $this->extendsPrepare($condition);

        $page = [
            'total' => $total, // 总条数
            'page_size' => ceil($total / $extends['limit']), // 总页数
            'current_page' => $extends['page'], // 当前页数
            'count_per_page' => $extends['limit'] // 一页显示条数
        ];
        return $page;
    }

    /**
     * 分页格式化
     * @param LengthAwarePaginator|null $data
     * @return array
     */
    protected function formatPagination(LengthAwarePaginator $data = null): array
    {
        $result = [
            'pagination' => null,
            'data' => []
        ];
        if ($data) {
            $data = $data->toArray();
            $result['data'] = $data['data'];

            unset($data['data']);
            unset($data['next_page_url']);
            unset($data['prev_page_url']);
            unset($data['path']);
            unset($data['last_page_url']);
            unset($data['first_page_url']);
            $result['pagination'] = $data;
        }
        return $result;
    }
}