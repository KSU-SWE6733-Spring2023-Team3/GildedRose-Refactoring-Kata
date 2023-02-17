<?php

declare(strict_types=1);

namespace Tests;

use GildedRose\GildedRose;
use GildedRose\Item;
use PHPUnit\Framework\TestCase;

class GildedRoseTest extends TestCase
{

    /*
     * TEST FUNCTION TEMPLATE -- COPY ME
     public function testFoo(): void
     {
        echo("Starting " . __FUNCTION__ . PHP_EOL);

        $items = [

        ];

        $gildedRose = new GildedRose($items);
     } // END testFoo()
     */

    /**
     * Make sure a regular item's quality degrades by 1 for each day.
     */
    public function testSimpleQualityDegrade(): void
    {
        echo("Starting " . __FUNCTION__ . PHP_EOL);
        // Make some basic variables
        $name = "foo";
        $sellIn = 3;
        $quality = 10;


        // Make an array of Item objects to pass to the GildedRose constructor
        $items = [
            new Item($name, $sellIn, $quality),
        ];


        // Make sure the item got created successfully
        $this->assertSame($name, $items[0]->name);
        $this->assertSame($sellIn, $items[0]->sellIn);
        $this->assertSame($quality, $items[0]->quality);

        // Make a new GildedRose
        $gildedRose = new GildedRose($items);

        // Make sure the original Items got set in the class correctly.
        $originalItems = $gildedRose->getItems();
        $this->assertSame($name, $originalItems[0]->name);
        $this->assertSame($sellIn, $originalItems[0]->sellIn);
        $this->assertSame($quality, $originalItems[0]->quality);
        echo($originalItems[0] . PHP_EOL);

        // Increment a day
        $gildedRose->updateQuality();

        // Now make sure the modified items have degredaded by one quality in one day.
        $modifiedItems = $gildedRose->getItems();
        $this->assertSame($name, $modifiedItems[0]->name);
        $this->assertSame(($sellIn - 1), $modifiedItems[0]->sellIn);
        $this->assertSame(($quality - 1), $modifiedItems[0]->quality);
        echo($modifiedItems[0] . PHP_EOL);
    }// END testSimpleQualityDegrade()

    /**
     * Make sure a regular item has it's Quality diminished by 2 when it is past the SellIn date
     */
    public function testPastSellByQualityDiminishChange(): void
    {
        echo("Starting " . __FUNCTION__ . PHP_EOL);

        $name = 'foo';
        $sellIn = 2;
        $quality = 10;

        $items = [
            new Item($name, $sellIn, $quality),
        ];

        $gildedRose = new GildedRose($items);


        $gildedRose->updateQuality();
        $oneDayItems = $gildedRose->getItems();
        $this->assertSame($name, $oneDayItems[0]->name);
        $this->assertSame(($sellIn - 1), $oneDayItems[0]->sellIn);
        $this->assertSame(($quality - 1), $oneDayItems[0]->quality);
        echo($oneDayItems[0] . PHP_EOL);

        $gildedRose->updateQuality();
        $twoDayItems = $gildedRose->getItems();
        $this->assertSame($name, $twoDayItems[0]->name);
        $this->assertSame(($sellIn - 2), $twoDayItems[0]->sellIn);
        $this->assertSame(($quality - 2), $twoDayItems[0]->quality);
        echo($twoDayItems[0] . PHP_EOL);

        $gildedRose->updateQuality();
        $threeDayItems = $gildedRose->getItems();
        $this->assertSame($name, $threeDayItems[0]->name);
        $this->assertSame(($sellIn - 3), $threeDayItems[0]->sellIn);
        $this->assertSame(($quality - 4), $threeDayItems[0]->quality);

        echo($threeDayItems[0] . PHP_EOL);
    } // END testPastSellByQualityDiminishChange()

    /**
     * Make sure that multiple items are set in the class correctly
     */
    public function testMultipleItemsSet(): void
    {
        echo("Starting " . __FUNCTION__ . PHP_EOL);

        $itemInfo = [
            [
                'name' => 'foo',
                'sellIn' => 10,
                'quality' => 10,
            ],
            [
                'name' => 'bar',
                'sellIn' => 15,
                'quality' => 30,
            ],
            [
                'name' => 'baz',
                'sellIn' => 4,
                'quality' => 10,
            ]
        ];

        $items = [];

        foreach ($itemInfo as $info) {
            array_push($items, new Item($info['name'], $info['sellIn'], $info['quality']));
        }

        $gildedRose = new GildedRose($items);

        $gildedRoseItems = $gildedRose->getItems();
        $this->assertSameSize($itemInfo, $gildedRoseItems);

        foreach ($gildedRoseItems as $key => $gildedRoseItem) {
            echo($gildedRoseItem . PHP_EOL);
            $this->assertSame($itemInfo[$key]['name'], $gildedRoseItem->name);
            $this->assertSame($itemInfo[$key]['sellIn'], $gildedRoseItem->sellIn);
            $this->assertSame($itemInfo[$key]['quality'], $gildedRoseItem->quality);
        }
    } // END testMultipleItemSet()

    /**
     * Make sure that Aged Brie increases in quality as it gets closer to it's sellIn date
     */
    public function testAgedBrieQualityIncrease(): void
    {
        echo("Starting " . __FUNCTION__ . PHP_EOL);

        $name = "Aged Brie";
        $sellIn = 10;
        $quality = 20;

        $items = [
            new Item($name, $sellIn, $quality),
        ];

        $gildedRose = new GildedRose($items);

        $gildedRose->updateQuality();
        $updatedItems = $gildedRose->getItems();
        $this->assertSame($name, $updatedItems[0]->name);
        $this->assertSame(($sellIn - 1), $updatedItems[0]->sellIn);
        $this->assertSame(($quality + 1), $updatedItems[0]->quality);
    } // END testAgedBrieQualityIncrease()
}
