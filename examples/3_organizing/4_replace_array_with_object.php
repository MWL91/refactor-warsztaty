<?php

use Illuminate\Contracts\Support\Arrayable;

require_once __DIR__ . '/../../vendor/autoload.php';

// Wrong:
$data = [];
$data['first_name'] = 'Marcin';
$data['last_name'] = 'Lenkowski';
$data['email'] = 'example@example.com';

// Good:
class Person implements Arrayable
{
    public function __construct(
        private ?string $first_name = '',
        private ?string $last_name = '',
        private ?string $email = '',
    )
    {
    }

    public function toArray(): array
    {
        return [
            'first_name' => $this->first_name,
            'last_name' => $this->last_name,
            'email' => $this->email,
        ];
    }

    public function setFirstName(string $first_name): void
    {
        $this->first_name = $first_name;
    }

    public function setLastName(string $last_name): void
    {
        $this->last_name = $last_name;
    }

    public function setEmail(string $email): void
    {
        $this->email = $email;
    }
}

$person = new Person();
$person->setFirstName('Marcin');
$person->setLastName('Lenkowski');
$person->setEmail('example@example.com');

var_dump($data);
var_dump($person->toArray());

dump(collect([$data, $data, $data])->toArray());
dump(collect([$person, $person, $person])->toArray()); // Dzięki zastosowaniu Arrayable