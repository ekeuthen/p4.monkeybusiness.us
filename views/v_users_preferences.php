<h2><?php echo $user->first_name; ?>'s Trip Ideas</h2>

<form method='POST' action='/users/p_preferences'>

    <h3>Create a new trip idea:</h3>

    <table>
        <tr>
            <td>Home Airport:</td>
            <td><input type="text" name="airport" id="airport" size="20"/></td>
        </tr>

        <!--what to do about expired preferences?-->
        <tr>
            <td>Travel Month:</td>
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
            </select> (optional)</td>
        </tr>

        <!--remove hard coded year -->
        <tr>
            <td>Travel Year:</td>
            <td><select name="year">
                <option value="0000"></option>
                <option value="2013">2013</option>
                <option value="2014">2014</option>
            </select> (optional)</td>
        </tr>

        <tr>
            <td>Region of Interest:</td>
            <td><select name="region">
                <option value="0"></option>
                <option value="f">Africa</option>
                <option value="a">Asia</option>
                <option value="c">Caribbean</option>
                <option value="m">Central America</option>
                <option value="e">Europe</option>
                <option value="u">North America</option>
                <option value="s">South America</option>
            </select> (optional)</td>
        </tr>

        <tr>
            <td>Maximum Price ($):</td>
            <td><input type="text" name="max_price" size="10"/> (optional)</td>
        </tr>
    </table>

    <input type='submit' value='Save'></br>

</form>

<h3>Current trip ideas:</h3>

<table id="preferenceList">
    <tr>
        <td>Home Airport</td>
        <td>Travel Dates</td>
        <td>Region</td>
        <td>Maximum Price ($)</td>
        <td>Create Date</td>
        <td>Delete</td>
    <tr>

    <?php foreach($preferences as $preference): ?>

        <tr>

            <td>
                <?=$preference['airport']?>
            </td>
            <td>
                <?=$preference['month']."-".$preference['year']?>
            </td>
            <td>
                <?=$preference['region']?>
            </td>
            <td>
                <?=$preference['max_price']?>
            </td>
            <td>
                <?php echo date('F d, Y', $preference['created']); ?>
            </td>
            <td>
                <!--Alllow users to delete a trip idea.-->
                <form method='POST' action='/users/p_preferences_delete'>
                    <input type='submit' value='Delete'>
                    <input type='hidden' name='preference_id' value='<?=$preference['preference_id']?>'>
                </form>
            </td>

        </tr>

    <?php endforeach; ?>
</table>