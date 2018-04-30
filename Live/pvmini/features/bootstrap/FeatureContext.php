<?php

namespace Schletter\GroundMount\Test\Context;

use Behat\Behat\Context\Context;
use Behat\Behat\Context\SnippetAcceptingContext;
use Behat\Gherkin\Node\TableNode;
use Behat\MinkExtension\Context\RawMinkContext;
use \PHPUnit_Framework_Assert as phpunit;

/**
 * Defines application features from the specific context.
 */
class FeatureContext extends RawMinkContext implements SnippetAcceptingContext
{
    /**
     * Check CSS selector for text.
     * 
     * @Then I should see:
     */ 
    public function iShouldSee(TableNode $fields)
    {
        $page = $this->getSession()->getPage();
        foreach ($fields->getRowsHash() as $field => $expected) {
            $actual = $page->find('css', $field)->getValue();
            phpunit::assertEquals($expected, $actual);
        }
    }

}
