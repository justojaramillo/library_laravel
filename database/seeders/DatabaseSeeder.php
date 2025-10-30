<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\User;
use App\Models\Author;
use App\Models\Book;
use App\Models\Loan;
use Carbon\Carbon;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        $user_client_1 = User::factory()->create([
            'name' => 'Justo Jaramillo',
            'email' => 'justo@example.com',
            'password' => Hash::make('12345678'),
            'role' => 'admin',
        ]);
        $user_client_2 = User::factory()->create([
            'name' => 'Laura Gómez',
            'email' => 'laura@example.com',
            'password' => Hash::make('12345678'),
            'role' => 'client',
        ]);
        $user_client_3 = User::factory()->create([
            'name' => 'Andrés Pérez',
            'email' => 'andres@example.com',
            'password' => Hash::make('12345678'),
            'role' => 'client',
        ]);
        User::factory()->create([
            'name' => 'Camila Rojas',
            'email' => 'camila@example.com',
            'password' => Hash::make('12345678'),
            'role' => 'client',
        ]);
        User::factory()->create([
            'name' => 'Ricardo Soto',
            'email' => 'ricardo@example.com',
            'password' => Hash::make('12345678'),
            'role' => 'client',
        ]);
        User::factory()->create([
            'name' => 'Diana Morales',
            'email' => 'diana@example.com',
            'password' => Hash::make('12345678'),
            'role' => 'client',
        ]);
        User::factory()->create([
            'name' => 'Fernando Velez',
            'email' => 'fernando@example.com',
            'password' => Hash::make('12345678'),
            'role' => 'client',
        ]);
        User::factory()->create([
            'name' => 'Gloria Restrepo',
            'email' => 'gloria@example.com',
            'password' => Hash::make('12345678'),
            'role' => 'client',
        ]);
        
        $author_1 = Author::factory()->create([
            'name' => 'Gabriel García Márquez',
            'nationality' => 'Colombia',
            'birth_day' => '1927-03-06',
        ]);
        $author_2 = Author::factory()->create([
            'name' => 'Isabel Allende',
            'nationality' => 'Chile',
            'birth_day' => '1942-08-02',
        ]);
        $author_3 = Author::factory()->create([
            'name' => 'Jorge Luis Borges',
            'nationality' => 'Argentina',
            'birth_day' => '1899-08-24',
        ]);
        $author_4 = Author::factory()->create([
            'name' => 'Julio Cortázar',
            'nationality' => 'Argentina',
            'birth_day' => '1914-08-26',
        ]);
        $author_5 = Author::factory()->create([
            'name' => 'Mario Vargas Llosa',
            'nationality' => 'Perú',
            'birth_day' => '1936-03-28',
        ]);
        $author_6 = Author::factory()->create([
            'name' => 'Octavio Paz',
            'nationality' => 'México',
            'birth_day' => '1914-03-31',
        ]);
        $author_7 = Author::factory()->create([
            'name' => 'Clarice Lispector',
            'nationality' => 'Brasil',
            'birth_day' => '1920-12-10',
        ]);
        $book_1 = Book::factory()->create([
            'title' => 'Cien años de soledad',
            'isbn' => '9788437604947',
            'author_id' => $author_1->author_id,
            'category' => 'Realismo mágico',
            'stock' => 5,
            'price' => 49.99,
        ]);
        $book_2 = Book::factory()->create([
            'title' => 'La casa de los espíritus',
            'isbn' => '9788437609171',
            'author_id' => $author_2->author_id,
            'category' => 'Ficción',
            'stock' => 8,
            'price' => 42.50,
        ]);
        $book_3 = Book::factory()->create([
            'title' => 'El Aleph',
            'isbn' => '9788420678255',
            'author_id' => $author_3->author_id,
            'category' => 'Cuento',
            'stock' => 12,
            'price' => 25.00,
        ]);
        Book::factory()->create([
            'title' => 'Ficciones',
            'isbn' => '9788420650916',
            'author_id' => $author_3->author_id,
            'category' => 'Ensayo',
            'stock' => 15,
            'price' => 28.50,
        ]);
        Book::factory()->create([
            'title' => 'El jardín de senderos que se bifurcan',
            'isbn' => '9788420635173',
            'author_id' => $author_3->author_id,
            'category' => 'Cuento',
            'stock' => 7,
            'price' => 30.00,
        ]);

        // Libros de Julio Cortázar ($author_4)
        Book::factory()->create([
            'title' => 'Rayuela',
            'isbn' => '9788437604817',
            'author_id' => $author_4->author_id,
            'category' => 'Novela',
            'stock' => 10,
            'price' => 55.99,
        ]);
        Book::factory()->create([
            'title' => 'Historias de cronopios y de famas',
            'isbn' => '9788437611846',
            'author_id' => $author_4->author_id,
            'category' => 'Cuento',
            'stock' => 6,
            'price' => 22.00,
        ]);
        Book::factory()->create([
            'title' => 'Bestiario',
            'isbn' => '9788437602387',
            'author_id' => $author_4->author_id,
            'category' => 'Ficción',
            'stock' => 9,
            'price' => 27.50,
        ]);

        // Libros de Mario Vargas Llosa ($author_5)
        Book::factory()->create([
            'title' => 'La ciudad y los perros',
            'isbn' => '9788466336323',
            'author_id' => $author_5->author_id,
            'category' => 'Novela',
            'stock' => 18,
            'price' => 45.00,
        ]);
        Book::factory()->create([
            'title' => 'La fiesta del Chivo',
            'isbn' => '9788466333339',
            'author_id' => $author_5->author_id,
            'category' => 'Histórica',
            'stock' => 4,
            'price' => 52.99,
        ]);
        Book::factory()->create([
            'title' => 'Conversación en La Catedral',
            'isbn' => '9788466336330',
            'author_id' => $author_5->author_id,
            'category' => 'Novela',
            'stock' => 11,
            'price' => 60.50,
        ]);

        // Libros de Octavio Paz ($author_6)
        Book::factory()->create([
            'title' => 'El laberinto de la soledad',
            'isbn' => '9786071603588',
            'author_id' => $author_6->author_id,
            'category' => 'Ensayo',
            'stock' => 14,
            'price' => 35.00,
        ]);
        Book::factory()->create([
            'title' => 'Libertad bajo palabra',
            'isbn' => '9788437607733',
            'author_id' => $author_6->author_id,
            'category' => 'Poesía',
            'stock' => 8,
            'price' => 32.50,
        ]);
        Book::factory()->create([
            'title' => 'Piedra de sol',
            'isbn' => '9788437607726',
            'author_id' => $author_6->author_id,
            'category' => 'Poesía',
            'stock' => 6,
            'price' => 20.00,
        ]);

        // Libros de Clarice Lispector ($author_7)
        Book::factory()->create([
            'title' => 'La hora de la estrella',
            'isbn' => '9788433973347',
            'author_id' => $author_7->author_id,
            'category' => 'Novela',
            'stock' => 10,
            'price' => 38.00,
        ]);
        Book::factory()->create([
            'title' => 'Cerca del corazón salvaje',
            'isbn' => '9788433973354',
            'author_id' => $author_7->author_id,
            'category' => 'Ficción',
            'stock' => 13,
            'price' => 41.50,
        ]);
        Book::factory()->create([
            'title' => 'Agua Viva',
            'isbn' => '9788433973361',
            'author_id' => $author_7->author_id,
            'category' => 'Prosa',
            'stock' => 5,
            'price' => 39.99,
        ]);
        // 3.1 Préstamo Activo 1: Laura toma "Cien años de soledad"
        Loan::create([
            'book_id' => $book_1->book_id,
            'user_id' => $user_client_1->user_id,
            'loan_date' => Carbon::yesterday(),
            'returned' => false,
        ]);
        // Actualizar stock
        $book_1->decrement('stock'); // Stock pasa de 5 a 4
        
        // 3.2 Préstamo Activo 2: Andrés toma "La casa de los espíritus"
        Loan::create([
            'book_id' => $book_2->book_id,
            'user_id' => $user_client_2->user_id,
            'loan_date' => Carbon::now(),
            'returned' => false,
        ]);
        // Actualizar stock
        $book_2->decrement('stock'); // Stock pasa de 8 a 7

        // 3.3 Préstamo Activo 3: Camila toma "El Aleph" (un préstamo con una fecha más antigua)
        Loan::create([
            'book_id' => $book_3->book_id,
            'user_id' => $user_client_3->user_id,
            'loan_date' => Carbon::create(2025, 1, 15),
            'returned' => false,
        ]);
        // Actualizar stock
        $book_3->decrement('stock'); // Stock pasa de 12 a 11
    }
}
