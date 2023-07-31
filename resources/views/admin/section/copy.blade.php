<footer class="main-footer">
    <div class="float-right d-none d-sm-inline">
        Developed By: Nectar Digit
    </div>
    <strong>Copyright &copy; 2020-{{ date('Y') }}
        <a href="{{ env('APP_URL') }}">
            {{ @$sitesetting->name ?? env('APP_NAME') }}
        </a>.
    </strong> All
    rights reserved.
</footer>
