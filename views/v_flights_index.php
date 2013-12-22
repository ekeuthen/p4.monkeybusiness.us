<h2><?php echo $user->first_name; ?>'s Flight Deals</h2>

<?php for ($i=0; $i<count($descriptions); $i++) { ?>

    <h2 class="description"><?php echo $descriptions[$i]; ?></h2>

    <table>

        <tr class="header">
            <td>Destination</td>
            <td>Price ($)</td>
            <td>Airline</td>
            <td>Depart</td>
            <td>Return</td>
        </tr>

        <?php foreach($items[$i] as $content): ?>

            <tr>

                <td>
                    <?=$content['destLocation']?>
                </td>

                <td>
                    <a href=<?=$content['url']?> target="_blank" class="link"><?=$content['price']?></a>
                </td>

                <td>
                    <?=$content['airline']?>
                </td>

                <td>
                    <?=$content['departDate']?>
                </td>

                <td>
                    <?=$content['returnDate']?>
                </td>

            </tr>

        <?php endforeach; ?>
    </table>

<?php } ?>

<h5>Don't see a trip idea you were looking for?  Add a new trip idea and try again!</h5>