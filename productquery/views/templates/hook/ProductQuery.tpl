<button class="btn btn-primary accordion">
 <span>
   {if $version >= '1.7'}
  <i class="material-icons">help_outline</i>
  {/if}
  <i class="icon-question"></i>
  </span>
  {l s='Ask About Product' mod='productquery'}
</button>
<div hidden id="form" class="card card-block">
  <div class="container-fluid">
     <form method="POST" id="formdata">
        <div class="row">
           <div class="form-group col-sm-3 col-md-6 col-lg-6">
            <label for="question">{l s='Your question*' mod='productquery'}</label>
            <textarea class="form-control rounded-0 tarea" name="textarea" id="tarea" rows="12"></textarea>
            <span class="form-control-comment">Only letters and numbers, are allowed.</span>
           </div>
           <div class="form-group col-sm-9 col-md-6 col-lg-6">
            <label for="name">{l s='Your name*' mod='productquery'}</label>
            <input type="text" class="form-control text" id="text" placeholder=" " name="text">
            <span class="form-control-comment">Only letters and numbers, are allowed.</span><br>

           <label for="email">{l s='Your email address*' mod='productquery'}</label>
           <input type="email" class="form-control" id="email" placeholder=" " name="email">

           <label for="number">{l s='phone number*' mod='productquery'}</label>
           <input type="number" class="form-control num" id="number" placeholder=" " name="number" maxlength="15">
           </div>
        </div>
        <hr>
          <input type="checkbox" class="form-check-input" id="check" name="checkbox" value="1">
          <label class="form-check-label" for="checkbox">{l s='I accept privacy policy rules' mod='productquery'}</label>
         <button type="submit" class="btn btn-primary float-xs-right float-right" id="btnsubmit" disabled>{l s='Send' mod='productquery'}</button> 
     </form>
</div>
   