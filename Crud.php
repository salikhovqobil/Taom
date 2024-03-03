<?php

class Crud
{
    private $dataFile = 'data.json';

    public function create($dish)
    {
        $dishes = $this->readData();
        $dishes[] = $dish;
        $this->saveData($dishes);
        return true;
    }

    public function readAll()
    {
        return $this->readData();
    }

    public function update($updatedDish)
    {
        $dishes = $this->readData();
        foreach ($dishes as &$dish) {
            if ($dish['name'] === $updatedDish['name']) {
                $dish = $updatedDish;
                break;
            }
        }
        $this->saveData($dishes);
        return true;
    }

    public function delete($dishName)
    {
        $dishes = $this->readData();
        $dishes = array_filter($dishes, function ($dish) use ($dishName) {
            return $dish['name'] !== $dishName;
        });
        $this->saveData($dishes);
        return true;
    }

    private function readData()
    {
        if (file_exists($this->dataFile)) {
            $data = file_get_contents($this->dataFile);
            return json_decode($data, true) ?: [];
        } else {
            return [];
        }
    }

    private function saveData($data)
    {
        file_put_contents($this->dataFile, json_encode($data, JSON_PRETTY_PRINT));
    }
}

?>


<div id="messages"></div>

<form id="crud-form" method="post" action="">
    <input type="hidden" name="action" id="action">
    <input type="text" name="dishName" id="dishName" placeholder="Dish Name" required>
    <input type="text" name="ingredients" id="ingredients" placeholder="Ingredients (comma-separated)" required>
    <input type="text" name="image" id="image" placeholder="Image URL" required>
    <button type="button" onclick="createOrUpdate('create')">Create</button>
    <button type="button" onclick="createOrUpdate('update')">Update</button>
    <button type="button" onclick="deleteData()">Delete</button>
</form>

<style>
    body {
        font-family: Arial, sans-serif;
        background-color: #111;
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
<script>function createOrUpdate(action) {
// Your existing code...

        fetch('', {
            method: 'POST',
            body: formData
        })
            .then(response => response.json())
            .then(data => {
                var messagesDiv = document.getElementById('messages');
                messagesDiv.innerHTML = '<div class="success">Operation successful!</div>';
// Additional logic or redirection if needed
            })
            .catch(error => {
                var messagesDiv = document.getElementById('messages');
                messagesDiv.innerHTML = '<div class="error">Operation failed! Please try again.</div>';
            });
    }

    >
</script>