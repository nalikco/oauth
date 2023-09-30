<?php

declare(strict_types=1);

namespace Tests\Feature\Http;

use Tests\TestCase;

class HomeTest extends TestCase
{
    /**
     * Test the view for the home route.
     */
    public function test_view(): void
    {
        // Send a GET request to the home route
        $response = $this->get(route('home'));

        // Assert that the response status is OK
        $response->assertOk();

        // Assert that the response contains the following texts in the given order
        $response->assertSeeTextInOrder([
            __('brand.nalikby'),
            __('brand.account'),
            __('brand.home.header'),
            __('brand.home.description'),
            __('brand.home.action_button'),
        ]);
    }
}
