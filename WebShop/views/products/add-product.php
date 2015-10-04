<div class="form-box" id="add-product">
<form class="form-horizontal" method="post" id="add-product-form">
    <fieldset>
        <legend>List new product</legend>
        <div class="form-group">
            <label for="name" class="col-lg-2 control-label">Name</label>
            <div class="col-lg-10">
                <?php
                    MVCFramework\ViewHelpers\TextField::create()
                        ->addAttribute('name', 'name')
                        ->addAttribute('class', 'form-control')
                        ->addAttribute('id', 'name')
                        ->addAttribute('placeholder', 'Name')
                    ->render();
                ?>
            </div>
        </div>
        <div class="form-group">
            <label for="description" class="col-lg-2 control-label">Description</label>
            <div class="col-lg-10">
<!--                <input type="text" name="description" class="form-control" id="description" placeholder="Description">-->
                <?php
                MVCFramework\ViewHelpers\TextField::create()
                    ->addAttribute('name', 'description')
                    ->addAttribute('class', 'form-control')
                    ->addAttribute('id', 'description')
                    ->addAttribute('placeholder', 'Description')
                ->render();
                ?>
            </div>
        </div>
        <div class="form-group">
            <label for="price" class="col-lg-2 control-label">Price</label>
            <div class="col-lg-10">
                <input type="number" min="1" step="any" name="price" class="form-control" id="price" placeholder="Price">
            </div>
        </div>
        <div class="form-group">
            <label for="quantity" class="col-lg-2 control-label">Quantity</label>
            <div class="col-lg-10">
                <input type="number" min="1" max="10" step="1" name="quantity" class="form-control" id="quantity" placeholder="Quantity">
            </div>
        </div>
        <div class="form-group">
            <label for="category" class="col-lg-2 control-label">Category</label>
            <div class="col-lg-10">
                    <?php
                        MVCFramework\ViewHelpers\DropDown::create()
                                ->addAttribute('class', 'form-control')
                                ->addAttribute('id', 'category')
                                ->addAttribute('name', 'category_id')
                                ->addAttribute('multiple', '')
                                ->setContent($this->categories,'getName','getId')
                            ->render();
                    ?>
            </div>
        </div>
        <?php MVCFramework\ViewHelpers\CsrfToken::create()
            ->render(); ?>
        <div class="form-group">
            <div class="col-lg-10 col-lg-offset-2">
                <input type="submit" class="btn btn-primary" value="List product"/>
            </div>
        </div>
    </fieldset>
</form>
</div>