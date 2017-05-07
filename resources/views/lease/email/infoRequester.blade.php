@component('mail::message')
# Order Shipped

Your order has been shipped!

@component('mail::button', ['url' => 'http://www.st-joris-turnhout.be'])
View Order
@endcomponent

Thanks,<br>
{{ config('app.name') }}
@endcomponent