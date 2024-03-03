<?php

class Ingredient
{
    public $name;
    public $image;

    public function __construct($name, $image)
    {
        $this->name = $name;
        $this->image = $image;
    }
}

$ingredients = array(
    new Ingredient("Piyoz", 'https://pngfre.com/wp-content/uploads/Onion-3-1.png'),
    new Ingredient("Kartoshka", 'https://images.rawpixel.com/image_png_800/cHJpdmF0ZS9sci9pbWFnZXMvd2Vic2l0ZS8yMDIzLTEyL3Jhd3BpeGVsX29mZmljZV8yNV9mbGF0X2xheV9vbmVfc2luZ2xlX2RlbGljaW91c19wb3RhdG9faG9yaXpvbl83NmFiMDU2NC0wNTJhLTRlYTQtYTEyNS0wYmQ4YjFiNWJiYWMucG5n.png'),
    new Ingredient("Yog", 'https://media.post.rvohealth.io/wp-content/uploads/sites/3/2020/02/324844_2200-1200x628.jpg'),
    new Ingredient("Go'sht", 'https://c0.klipartz.com/pngpicture/17/1014/gratis-png-carne-cruda-en-rodajas-carne-de-bistec-carne-roja-carne-ingredientes-de-carne-thumbnail.png'),
    new Ingredient("Bulg'or qalampir", 'https://w7.pngwing.com/pngs/419/293/png-transparent-red-bell-pepper-bell-pepper-vegetarian-cuisine-vegetable-trinidad-moruga-scorpion-seed-red-pepper-natural-foods-food-cayenne-pepper.png'),
    new Ingredient("Pomidor", 'https://png.pngtree.com/png-clipart/20230113/ourmid/pngtree-red-fresh-tomato-with-green-leaf-png-image_6561484.png'),
    new Ingredient("Bodiring", 'https://purepng.com/public/uploads/large/purepng.com-cucumbercucumbervegetablespicklegreenfoodhealthycucumbers-481522161925n6wbx.png'),
    new Ingredient("Tuz", 'https://www.pngarts.com/files/4/Salt-PNG-Download-Image.png'),
    new Ingredient("Shakar", 'https://api.cabinet.smart-market.uz/uploads/images/ff8081817b7dba151f133647'),
);

class Dish
{
    public $name;
    public $image;

    public $ingredients = array();

    public function __construct($name, $ingredients, $image)
    {
        $this->name = $name;
        $this->ingredients = $ingredients;
        $this->image = $image;
    }
}

$dishes = array(
    new Dish("Kartoshka Palov", array("Piyoz", "Yog'","Kartoshka","Tuz",), 'https://i.ytimg.com/vi/NUZeMB8T0PU/maxresdefault.jpg'),
    new Dish("Jizza", array("Piyoz", "Yog'", "Go'sht"), 'https://i.ytimg.com/vi/NUZeMB8T0PU/maxresdefault.jpg'),
    new Dish("Qozon Kabob", array("Piyoz", "Kartoshka", "Go'sht"), 'https://i.ytimg.com/vi/NUZeMB8T0PU/maxresdefault.jpg'),
//    new Dish("Jizza", array("Piyoz", "Yog'"), 'https://i.ytimg.com/vi/NUZeMB8T0PU/maxresdefault.jpg'),
//    new Dish("Achichu", array("Piyoz", "Pomidor'", "Bodring"), 'https://i.ytimg.com/vi/NUZeMB8T0PU/maxresdefault.jpg')
);

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $selectedIngredients = $_POST['ingredients'];
    $possibleDishes = array();

    foreach ($dishes as $dish) {
        if (count(array_diff($dish->ingredients, $selectedIngredients)) == 0) {
            array_push($possibleDishes, $dish->name);
        }
    }

    echo json_encode($possibleDishes);
    exit();
}
?>

<!DOCTYPE html>
<html>
<head>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #fff;
        }

        h1 {
            text-align: center;
            color: darkgreen;
        }

        .ingredient-list {
            list-style-type: none;
            padding: 0;
            display: flex;
            flex-wrap: wrap;
            justify-content: space-around;
        }

        .ingredient-list li {
            margin: 10px;
            background-color: green;
            border-radius: 5px;
            padding: 10px;
            display: flex;
            align-items: center;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.15);
        }

        .ingredient-list li label {
            margin-right: 10px;
            flex-grow: 1;
        }

        .ingredient-list li img {
            width: 50px;
            height: 50px;
            margin-right: 10px;
        }

        button {
            display: block;
            margin: 20px auto;
            padding: 10px 20px;
            background-color: green;
            color: #fff;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-size: 1.2em;
        }

        button:hover {
            background-color: darkgreen;
        }

        #possible-dishes {
            margin-top: 20px;
            font-size: 1.2em;
            text-align: center;
            color: darkgreen;
        }
    </style>
</head>
<body>
<h1>Masalliqlarni tanlang:</h1>
<form id="ingredients-form" method="post" action="">
    <ul class="ingredient-list">
        <?php foreach ($ingredients as $ingredient) : ?>
            <li>
                <img src="<?= $ingredient->image ?>" alt="<?= $ingredient->name ?>">
                <label for="<?= strtolower($ingredient->name) ?>"><?= $ingredient->name ?></label>
                <input type="checkbox" id="<?= strtolower($ingredient->name) ?>" name="ingredients[]"
                       value="<?= $ingredient->name ?>">
            </li>
        <?php endforeach; ?>
    </ul>
    <button type="button" onclick="checkPossibleDishes()">Taomlarni tekshirish</button>
</form>
<div id="possible-dishes"></div>

<script>
    function checkPossibleDishes() {
        var form = document.getElementById('ingredients-form');
        var formData = new FormData(form);

        fetch('', {
            method: 'POST',
            body: formData
        })
            .then(response => response.json())
            .then(data => {
                var dishesDiv = document.getElementById('possible-dishes');
                dishesDiv.innerHTML = '<h2>Mumkin bo\'lgan taomlar:</h2>' + data.join(', ');
            });
    }
</script>
</body>
</html>

<script>
    function createOrUpdate(action) {
        var form = document.getElementById('crud-form');
        document.getElementById('action').value = action;
        form.submit();
    }

    function deleteData() {
        var form = document.getElementById('crud-form');
        document.getElementById('action').value = 'delete';
        form.submit();
    }

</script>
