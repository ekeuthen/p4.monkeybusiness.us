<h2><?php echo $user->first_name; ?>'s Trip Ideas</h2>

<form method='POST' action='/users/p_preferences'>

    <h3>Create a new trip idea:</h3>

    <table>
        <tr>
            <td>Home Airport:</td>
            <td><input type="text" name="airport" id="airport" size="20" required=''/></td>
        </tr>

        <!--what to do about expired preferences?-->
        <tr>
            <td>Travel Month / Year:</td>
            <td><select name="month">
                <option value=""></option>
                <option value="01">January</option>
                <option value="02">February</option>
                <option value="03">March</option>
                <option value="04">April</option>
                <option value="05">May</option>
                <option value="06">June</option>
                <option value="07">July</option>
                <option value="08">August</option>
                <option value="09">September</option>
                <option value="10">October</option>
                <option value="11">November</option>
                <option value="12">December</option>
            </select>
            <!--remove hard coded year -->
            <select name="year">
                <option value=""></option>
                <option value="2013">2013</option>
                <option value="2014">2014</option>
            </select> (optional)</td>
        </tr>

        <tr>
            <td>Destination of Interest:</td>
            <td><select name="region">
                <option value=""></option>
                <option value="Africa">Africa</option>
                <option value="Asia">Asia</option>
                <option value="Caribbean">Caribbean</option>
                <option value="Central America">Central America</option>
                <option value="Europe">Europe</option>
                <option value="North America">North America</option>
                <option value="South America">South America</option>
            </select> (optional)</td>
        </tr>

        <tr>
            <td>Maximum Price ($):</td>
            <td><input type="number" min="0" name="max_price" size="10"/> (optional)</td>
        </tr>
    </table>

    <input type='submit' value='Save'></br>

</form>

<h3>Current trip ideas:</h3>

<table id="preferenceList">
    <tr>
        <td>Delete</td>
        <td>Create Date</td>
        <td>Home Airport</td>
        <td>Travel Dates</td>
        <td>Destination</td>
        <td>Maximum Price ($)</td>
    <tr>

    <?php foreach($preferences as $preference): ?>

        <tr>
            <td>
                <!--Alllow users to delete a trip idea.-->
                <form method='POST' action='/users/p_preferences_delete'>
                    <input type='submit' value='Delete'>
                    <input type='hidden' name='preference_id' value='<?=$preference['preference_id']?>'>
                </form>
            </td>
            <td>
                <?php echo date('F d, Y', $preference['created']); ?>
            </td>
            <td>
                <?=$preference['airport']?>
            </td>
            <td>
                <?php if (isset($preference['month'])) echo $preference['month'].'/'.$preference['year'];?>
            </td>
            <td>
                <?=$preference['region']?>
            </td>
            <td>
                <?=$preference['max_price']?>
            </td>

        </tr>

    <?php endforeach; ?>
</table>