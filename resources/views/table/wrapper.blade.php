{{--<div class="flex flex-col">--}}
{{--    <div class="-my-2 overflow-x-auto">--}}
{{--        <div class="py-2 align-middle inline-block min-w-full sm:px-px">--}}
{{--            <div class="shadow-sm relative border border-gray-200 sm:rounded-md sm:overflow-hidden">--}}
{{--                {{ $slot }}--}}
{{--            </div>--}}
{{--        </div>--}}
{{--    </div>--}}
{{--</div>--}}
<div class="flex flex-col py-2 -my-2">
    <div class="overflow-x-auto align-middle inline-block min-w-full sm:px-px shadow-sm border border-gray-200 sm:rounded-md">
        {{ $slot }}
    </div>
</div>
