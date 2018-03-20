<aside class="main-sidebar">

    <section class="sidebar">

        <!-- Sidebar user panel -->
        <div class="user-panel">
            <div class="pull-left image">
                <img src="<?= $directoryAsset ?>/img/user2-160x160.jpg" class="img-circle" alt="User Image"/>
            </div>
            <div class="pull-left info">
                <p>阳子美美</p>

                <a href="#"><i class="fa fa-circle text-success"></i> Online</a>
            </div>
        </div>

        <!-- search form -->
        <form action="#" method="get" class="sidebar-form">
            <div class="input-group">
                <input type="text" name="q" class="form-control" placeholder="Search..."/>
              <span class="input-group-btn">
                <button type='submit' name='search' id='search-btn' class="btn btn-flat"><i class="fa fa-search"></i>
                </button>
              </span>
            </div>
        </form>
        <!-- /.search form -->

        <?= dmstr\widgets\Menu::widget(
            [
                'options' => ['class' => 'sidebar-menu tree', 'data-widget'=> 'tree'],
                'items' => [
                    [
                        'label' => '商品模块', 'icon' => 'cart-arrow-down', 'url' => ['index'],
                        'items' => [
                            ['label' => '商品管理', 'icon' => 'paint-brush', 'url' => ['goods/index'],],
                            ['label' => '商品分类', 'icon' => 'folder-open', 'url' => ['goods-cate/index'],],
                        ],
                    ],
                ],
            ]
        ) ?>
        <?= dmstr\widgets\Menu::widget(
            [
                'options' => ['class' => 'sidebar-menu tree', 'data-widget'=> 'tree'],
                'items' => [
                    [
                        'label' => '品牌模块', 'icon' => 'yelp', 'url' => ['index'],
                        'items' => [
                            ['label' => '品牌管理', 'icon' => 'hand-lizard-o', 'url' => ['brand/index'],],

                        ],
                    ],
                ],
            ]
        ) ?>
        <?= dmstr\widgets\Menu::widget(
            [
                'options' => ['class' => 'sidebar-menu tree', 'data-widget'=> 'tree'],
                'items' => [
                    [
                        'label' => '文章模块', 'icon' => 'file-text', 'url' => ['index'],
                        'items' => [
                            ['label' => '文章管理', 'icon' => 'magic', 'url' => ['article/index'],],
                            ['label' => '文章分类', 'icon' => 'folder-open', 'url' => ['article-cate/index'],],
                        ],
                    ],
                ],
            ]
        ) ?>
        <?= dmstr\widgets\Menu::widget(
            [
                'options' => ['class' => 'sidebar-menu tree', 'data-widget'=> 'tree'],
                'items' => [
                    [
                        'label' => '管理模块', 'icon' => 'user-circle', 'url' => ['index'],
                        'items' => [
                            ['label' => '登录', 'icon' => 'user', 'url' => ['#'],],
                            ['label' => '注册', 'icon' => 'user-plus', 'url' => ['#'],],
                        ],
                    ],
                ],
            ]
        ) ?>
    </section>

</aside>
