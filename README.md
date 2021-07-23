# API - JTR

## Estrutura do projeto

A estrutura do projeto foi baseada no curso Laravel Hardcore da [Codecasts](https://github.com/codecasts/confee-api), alterei bastante coisas do código dele seguindo o mesmo padrão que o curso determinou.

## Docker

Neste projeto foi utilizado o docker como ambiente de desenvolvimento e nele utilizeo as seguintes tecnologias:

- NGINX
- PHP 7.4.2
- MYSQL 5.7
- REDIS Latest

## API

Como o nome já diz, era pra ser uma API para uma empresa de ar condicionado chamada JTR Ar condicionado, por alguns problemas na empresa o projeto acabou sendo cancelado.

## Exceptions Handler

O arquivo Exceptions Handler foi totalmente alterado para sempre retornar JSON.

## Autenticação

A autenticação é realizada via JWT Token, no projeto foi utilizado o pacote [tymon/jwt-auth](https://github.com/tymondesigns/jwt-auth) para a criação dos tokens.

## Usuários

A parte de usuários é padrão do Laravel

## Customers

Aqui que realmente começa o projeto, criação dos customers tenteo deixar algo simples, apenas recolhendo o documento sendo eles CPF ou CNPJ, o mesmo sendo válidados para não ter conflitos ou documentos inválidos.

~~~php
public function up(): void
{
  $this->schema->create('customers', function (Blueprint $table) {
    $table->uuid('id')->primary();
    $table->bigInteger('document_number')->unique();
    $table->string('email')->unique();
    $table->string('name');
    $table->string('website')->nullable();
    $table->timestamps();
  });
}
~~~

Para a validação do CPF/CNPJ foi utlizado o pacote [eltoninacio/cpfcnpj-laravel](https://github.com/eltoninacio/cpfcnpj-laravel), no arquivo CreateCustomerRequest/UpdateCustomerRequest ficou assim:

~~~php
/**
 * Get the validation rules that apply to the request.
 *
 * @return array
 */
public function rules(): array
{
  return [
    "document_number" => "required|numeric|cpfcnpj|unique:customers",
    "name"            => "required|string",
    "email"           => "required|string|email|max:255|unique:customers",
    "website"         => "nullable|url",
  ];
}
~~~

Na criação de Ordem de Serviços, o meu pensamento para criar a ordem de serviço foi assim: O cliente entrasse em contato com a empresa e reportasse o que estava acontecendo com o equipamento (campo: reported_problem), o técnicos iriam até o local para averiguar o problema e relatasse o que realmente esta acontecendo (campo: found_problem) e quando o serviço estiver concluído descrevesse qual foi o procedimento que foi realizado (campo: service_description).

~~~php
public function up(): void
{
  $this->schema->create('service_orders', function (Blueprint $table) {
    $table->uuid('id')->primary();
    $table->uuid('customer_id');
    //$table->uuid('technician'); Depois vai ser utilizado para adicionar um técnico existente, talvez criar uma migrations só para adicionar esse campo.
    $table->unsignedBigInteger('order_number')->default(0);
    $table->string('type_service');
    $table->enum('status', ['canceled', 'pending', 'completed'])->default('pending');
    $table->enum('priority', ['low', 'medium', 'high'])->default('low');
    $table->text('reported_problem')->nullable();
    $table->text('found_problem')->nullable();
    $table->longText('service_description')->nullable();
    $table->timestamps();

    $table->foreign('customer_id')->references('id')->on('customers')->onDelete('CASCADE');
  });
}
~~~

Como o projeto não foi concluído, minha ideia iria criar um outra tabela dos equipamentos que o técnico reparou.


A tabela abaixo não existe, era apenas um pensamento de como iria construir.
~~~php
public function up(): void
{
  $this->schema->create('equipaments', function (Blueprint $table) {
    $table->uuid('id')->primary();
    $table->uuid('order_id');
    //$table->uuid('technician'); Depois vai ser utilizado para adicionar um técnico existente, talvez criar uma migrations só para adicionar esse campo.
    $table->unsignedBigInteger('order_number')->default(0);
    $table->string('type_service');
    $table->enum('status', ['canceled', 'pending', 'completed'])->default('pending');
    $table->enum('priority', ['low', 'medium', 'high'])->default('low');
    $table->text('reported_problem')->nullable();
    $table->text('found_problem')->nullable();
    $table->longText('service_description')->nullable();
    $table->timestamps();

    $table->foreign('order_id')->references('id')->on('customers')->onDelete('CASCADE');
  });
}
~~~
