<!-- Modal -->
<?php
$priceFrom = 0;
$priceTo = 0;
$categoryID = 0;
$colorName = 'none';
$sortOrder = 'ASC';
$keywords = "";

if(isset($_GET['priceFrom'])){
    $priceFrom = $_GET['priceFrom'];
}
if(isset($_GET['priceTo'])){
    $priceTo = $_GET['priceTo'];
}
if(isset($_GET['categoryID'])){
    $categoryID = $_GET['categoryID'];
}
if(isset($_GET['colorName'])){
    $colorName = $_GET['colorName'];
}
if(isset($_GET['sortPrice'])){
    $sortOrder = $_GET['sortPrice'] == 'LtoH' ? 'DESC' : 'ASC';
}if(isset($_GET['keyWords'])){
    $keywords = strtolower($_GET['keyWords']);
}
?>

<div class="modal fade" id="searchWithFilterModel" tabindex="-1" aria-labelledby="searchWithFilterModelLabel"
     aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content" style="width: 600px">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="searchWithFilterModelLabel">Search With Filters</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-3 fw-bold">
                        Price Start from
                    </div>
                    <div class="col-3">
                        <input type="text" class="form-control" id="priceFrom" value="<?php echo $priceFrom?>">
                    </div>
                    <div class="col-1 fw-bold">
                        to
                    </div>
                    <div class="col-3">
                        <input type="text" class="form-control" id="priceTo" value="<?php echo $priceTo?>">
                    </div>
                </div>

                <div class="row mt-3">

                    <div class="col-6 ">
                        <div class="row">
                            <div class="col-12 fw-bold">
                                Category
                            </div>
                            <div class="col-12">
                                <select class="form-control" name="category_select" id="category_select" >
                                    <option class="form-check" value="0">Not Specified</option>
                                    <?php
                                    $db = new \database\Database();
                                    $query = "SELECT * FROM categories";
                                    $db->query($query);
                                    $results = $db->resultSet();

                                    foreach ($results as $result){
                                        $id = $result['cat_id'];
                                        $cat = $result['category'];
                                        ?>
                                        <option class="form-check" value="<?php echo  $id?>"><?php echo $cat?></option>
                                    <?php

                                    }
                                    ?>

                                </select>
                            </div>
                        </div>


                    </div>
                    <div class="col-6 ">
                        <div class="row">
                            <div class="col-12 fw-bold">
                                Color
                            </div>
                            <div class="col-12">
                                <select class="form-control" name="color_select" id="color_select">
                                    <option class="form-check" value="0">Not Specific</option>
                                    <?php
                                    $db = new \database\Database();
                                    $query = "SELECT * FROM color";
                                    $db->query($query);
                                    $results = $db->resultSet();
                                    $colors = array();
                                    foreach ($results as $result){
                                        $id = $result['color_id'];
                                        $color = $result['color_name'];
                                       if(in_array($color, $colors)){

                                       }else{
                                           array_push($colors, $color);

                                        ?>
                                        <option class="form-check" value="<?php echo  $color?>"><?php echo $color?>  </option>
                                    <?php
                                       }
                                    }

                                    ?>
                                    <option class="form-check" value="1">
                                    </option>

                                </select>
                            </div>
                        </div>


                    </div>
                </div>

                <div class="row mt-3">
                    <div class="col-12 fw-bold">
                        Short Price
                    </div>
                    <div class="col-3">
                        <label for="LtoH"> Low To High</label>
                        <input type="radio" value="LtoH" name="shortPrice" id="LtoH" checked>
                    </div>
                    <div class="col-3">
                        <label for="HtoL"> High To Low</label>
                        <input type="radio" value="HtoL" name="shortPrice" id="HtoL">
                    </div>
                    <div class="col-6">
                        <div class="row fw-bold">
                            KeyWords
                        </div>
                        <div class="row">
                            <div class="col-12">
                                <input type="text" class="form-control" id="keyWords" onchange="keywordBoxOnchange()" value="<?php  echo  $keywords?>" >
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary" onclick="searchProductWithFilters()">Search</button>
            </div>
        </div>
    </div>
</div>
<script>
    document.getElementById('category_select').value = '<?php echo $categoryID ?>';
    document.getElementById('color_select').value = '<?php echo $colorName ?>';
</script>