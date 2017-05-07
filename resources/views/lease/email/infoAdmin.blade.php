@component('mail::message')
# Order Shipped

Your order has been shipped!

@component('mail::table')
|       |       | 
| ------------- | ---------------:|
| Col 2 is      | Centered      | 
| Col 3 is      | Right-Aligned | 
@endcomponent

@component('mail::button', ['url' => 'http://www.st-joris-turnhout.be'])
    View Order
@endcomponent

Met vriendelijke groet,<br>
Scouts en Gidsen - SInt-Joris
@endcomponent