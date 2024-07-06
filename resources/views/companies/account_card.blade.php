<div class="card style-4 position-relative grid-item account">
    <input class="account_id" type="hidden" name="account_id[]" value="{{$account->id}}">
    <span class="deleteCard" onclick="deleteAccount(this)">
        <svg style="margin-top: -2px" xmlns="http://www.w3.org/2000/svg" width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3" stroke-linecap="round" stroke-linejoin="round" class="feather feather-x"><line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/></svg>    
    </span>
    <div class="card-body p-3">
        <div class="media mt-0">
            <div class="media-body">

            <div class="d-flex flex-column justify-content-between" style="height: 180px;">
                <div>
                    @if(!isset($account->account_number))
                        <p class="media-heading mb-0"><b>Número de cuenta:</b> N/A</p>
                    @else
                        <p class="media-heading mb-0"><b>Número de cuenta:</b></p>
                        <p>{{$account->account_number ?? "N/A"}}</p>
                    @endif

                    @if(!isset($account->clabe))
                        <p class="media-heading mb-0"><b>CLABE:</b> N/A</p>
                    @else
                        <p class="media-heading mb-0"><b>CLABE:</b></p>
                        <p>{{$account->clabe ?? "N/A"}}</p>
                    @endif
                </div>

                <div>
                    <p class="mb-0">AVA: {{$account->ava ?? ""}}</p>
                    <p class="mb-0">SWIFT: {{$account->swift ?? ""}}</p>
                </div>
                <div class="d-flex justify-content-between align-items-end">
                    <p class="m-0">{{$account->bank->name ?? "N/A"}}</p>
                    <p class="m-0">{{$account->currencyType->name ?? "N/A"}}</p>
                </div>
            </div>

            </div>
        </div>
    </div>
</div>