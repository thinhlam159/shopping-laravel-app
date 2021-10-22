<?php

namespace App\Components;

use App\Models\Menu;

class Recusive
{
    private $data;
    private $htmlSelection = '';
    private $menuSelectHtml = '';

    public function __construct($data)
    {
        $this->data = $data;
    }

    public function categoryRecusive($parentId = null, $id = 0, $text = '')
    {
        foreach ($this->data as $value) {
            if ($value['parent_id'] === $id) {
                if (!empty($parentId) && $parentId == $value['id']) {
                    $this->htmlSelection .= "<option selected value='" . $value['id'] . "'>" . $text . $value['name'] . "</option>";
                } else {
                    $this->htmlSelection .= "<option value='" . $value['id'] . "'>" . $text . $value['name'] . "</option>";
                }
                $this->categoryRecusive($parentId, $value['id'], $text . '--');
            }
        }
        return $this->htmlSelection;
    }

    public function menuRecusive($parentId = null, $id = 0, $text = '')
    {
        $menuList = Menu::where('parent_id', $id)->get();
        foreach ($menuList as $value) {
            if (!empty($parentId) && $parentId == $value['id']) {
                $this->menuSelectHtml .= "<option selected value='" . $value['id'] . "'>" . $text . $value['name'] . "</option>";
            } else {
                $this->menuSelectHtml .= "<option value='" . $value['id'] . "'>" . $text . $value['name'] . "</option>";
            }
            $this->menuRecusive($parentId, $value['id'], $text . '--');
        }
        return $this->menuSelectHtml;
    }


}
