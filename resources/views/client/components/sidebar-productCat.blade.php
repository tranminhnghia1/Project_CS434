<div class="section-head">
    <h3 class="section-title">Danh mục sản phẩm</h3>
</div>
<div class="secion-detail">

    @php
   // $category=Product_cat::where('status', '=', 'posted')->get();
    function has_child($category,$id){
        foreach ($category as $k) {
            if ($k['parent_cat'] == $id) return true;
        }
    }
    function renderMenu($category,$parent_cat=0,$level=0){
        if($level==0){
            $result = "<ul class='list-item'>";
        }else {
            $result = "<ul class='sub-menu'>" ;
        }
        foreach ($category as $k) {
            if ($k['parent_cat'] == $parent_cat) {
              $link = route('category-product',$k['slug_productCat']);
              $result.="<li>";
              $result.="<a href='{$link}'>{$k['name']}</a>";
              if(has_child($category,$k['id'])){
                    $result.=renderMenu($category,$k['id'],$level + 1);
              }
              $result.="</li>";
             // unset($data[$item['id']]);
              
               
              
             
           }
        }
        $result.="</ul>";
        return $result;
    }
   echo renderMenu($category);
    @endphp
</div>