<h1 align="center">Aspire Loan Home Test</h1>
<h4>This project is an implementation of an simple loan application system. </br>
When a user signup he can view available loan types and then apply for a loan.
When the loan is approved it is then scheduled for payment and the frequency of payment is done 
weekely.
</h4>

## Aspire Loan Application Setup
- **Run this command pn your root project chmod +x ./start-server.sh**
- **sudo ./start-server.sh**

## **Steps**

- On the **Subscriber**, run ```php artisan serve --port=8000``` to start it.
- In order to run unit test you need to create a test.sqlite
- Type touch database/test.sqlite on your console
- Run php artisan test for your unit and feature test

## License

The Laravel framework is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).
