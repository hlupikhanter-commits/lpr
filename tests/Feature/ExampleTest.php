<?php

namespace Tests\Feature;

use Tests\TestCase;

class ExampleTest extends TestCase
{
    public function test_root_redirects_to_catalog(): void
    {
        $response = $this->get('/');
        $response->assertRedirect('/catalog');
    }

    public function test_catalog_index_displays_pets(): void
    {
        $response = $this->get('/catalog');
        $response->assertStatus(200);
        $response->assertSee('Каталог питомцев');
        $response->assertSee('Барсик');
        $response->assertSee('Персик');
    }

    public function test_catalog_filter_and_sort(): void
    {
        $response = $this->get('/catalog?q=Барс&sort=weight_kg');
        $response->assertStatus(200);
        $response->assertSee('Барсик');
        $response->assertDontSee('Рекс');
    }

    public function test_catalog_show_by_id(): void
    {
        $response = $this->get('/catalog/1');
        $response->assertStatus(200);
        $response->assertSee('Барсик');
        $response->assertSee('VET-10001');
    }

    public function test_catalog_show_by_code(): void
    {
        $response = $this->get('/catalog/code/VET-10002');
        $response->assertStatus(200);
        $response->assertSee('Рекс');
    }

    public function test_catalog_invalid_code_gives_404(): void
    {
        $response = $this->get('/catalog/code/vet-10002');
        $response->assertStatus(404);
    }

    public function test_catalog_abc_gives_404(): void
    {
        $response = $this->get('/catalog/abc');
        $response->assertStatus(404);
    }

    public function test_catalog_owners_list(): void
    {
        $response = $this->get('/catalog/owner');
        $response->assertStatus(200);
        $response->assertSee('Смирнов Алексей');
        $response->assertSee('Иванова Елена');
    }

    public function test_catalog_filter_by_owner(): void
    {
        $response = $this->get('/catalog/owner/' . urlencode('Смирнов Алексей'));
        $response->assertStatus(200);
        $response->assertSee('Барсик');
        $response->assertSee('Рекс');
        $response->assertDontSee('Майло');
    }

    public function test_catalog_stats(): void
    {
        $response = $this->get('/catalog/stats');
        $response->assertStatus(200);
        $response->assertSee('Статистика питомцев');
        $response->assertSee('7');
    }

    public function test_feedback_form_submission_and_redirect(): void
    {
        $response = $this->post('/feedback', [
            'name' => 'Темирлан',
            'message' => 'Тестовое сообщение',
        ]);

        $response->assertRedirect('/feedback');
        $response->assertSessionHas('status', 'Спасибо, Темирлан! Сообщение получено: Тестовое сообщение');

        $followed = $this->get('/feedback');
        $followed->assertStatus(200);
        $followed->assertSee('Спасибо, Темирлан!');
    }

    public function test_hello_route_cyrillic(): void
    {
        $response = $this->get('/hello/' . urlencode('Темирлан'));
        $response->assertStatus(200);
        $response->assertSee('Привет, Темирлан!');
    }
}
