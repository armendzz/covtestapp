<x-app-layout>
    <x-slot name="header">
      <h2 class="font-semibold text-xl text-gray-800 leading-tight">
          {{ __('Kunde suchen') }}
      </h2>
  </x-slot>

  <div class="container">
  
      <div class="card pb-5">
          
         <livewire:kunden/> 
          <div class="card-body">
            @if($kunden->isEmpty())
            <div class="text-gray-500 text-sm">
               Keine Kunden vorhanden.
            </div>
        @else
            @foreach($kunden as $kunde)
                <div class="client">
                    <div class="client-info">
                    <h3 class="text-lg text-gray-900 text-bold">{{$kunde->fn}} {{$kunde->ln}}</h3> <div class="clients-buttons"> <a class="btn btn-primary mx-2 btn-md" href="/kunde/{{$kunde->id}}">Testen</a><a class="btn btn-info mx-2 btn-md" href="/kunde/{{$kunde->id}}/edit">Daten bearbeiten</a> <form action="/kunde/{{$kunde->id}}" method="post">@csrf @method('delete') <button type="submit" class="btn btn-danger mx-2 btn-md" href="/kunde/{{$kunde->id}}">Löschen</button></form> </div>
                </div>
                    <p class="text-gray-500 text-sm">{{$kunde->email}} | {{$kunde->addresse}} | {{$kunde->dob}} | Getestet: {{  count($kunde->tests)}}x</p>
                    <p class="text-gray-500"></p>
                
                </div>
            @endforeach
            <div class="paginate">
                {{$kunden->links()}}
            </div>
           
        @endif
           
          </div>
      </div>
     
      </div>
    
      
  </div>

</x-app-layout>