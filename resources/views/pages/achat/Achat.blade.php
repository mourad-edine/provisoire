<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', 'Mon Site')</title>

    <!-- Tailwind CSS -->

    <!-- Font Awesome -->
     <!-- <link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin> -->
<!-- <link href="https://fonts.googleapis.com/css2?family=Archivo:ital,wght@0,100..900;1,100..900&family=Bellota:ital,wght@0,300;0,400;0,700;1,300;1,400;1,700&family=Cinzel:wght@400..900&family=Lobster&family=Montserrat+Alternates:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&family=Nunito:ital,wght@0,200..1000;1,200..1000&family=Open+Sans:ital,wght@0,300..800;1,300..800&family=Permanent+Marker&family=Shadows+Into+Light&display=swap" rel="stylesheet"> -->
    <link rel="stylesheet" href="{{ asset('assets/vendor/fontawesome-free/css/all.min.css') }}">

    <link rel="stylesheet" href="{{ asset('assets/select2/dist/css/select2.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/select2-bootstrap-5-theme.min.css') }}">


  @if (file_exists(public_path('build/manifest.json')) || file_exists(public_path('hot')))
            @vite(['resources/css/app.css', 'resources/js/app.js'])
        @else
            <style>
                /*! tailwindcss v4.0.7 | MIT License | https://tailwindcss.com */@layer theme{:root,:host{--font-sans:'Instrument Sans',ui-sans-serif,system-ui,sans-serif,"Apple Color Emoji","Segoe UI Emoji","Segoe UI Symbol","Noto Color Emoji";--font-serif:ui-serif,Georgia,Cambria,"Times New Roman",Times,serif;--font-mono:ui-monospace,SFMono-Regular,Menlo,Monaco,Consolas,"Liberation Mono","Courier New",monospace;--color-red-50:oklch(.971 .013 17.38);--color-red-100:oklch(.936 .032 17.717);--color-red-200:oklch(.885 .062 18.334);--color-red-300:oklch(.808 .114 19.571);--color-red-400:oklch(.704 .191 22.216);--color-red-500:oklch(.637 .237 25.331);--color-red-600:oklch(.577 .245 27.325);--color-red-700:oklch(.505 .213 27.518);--color-red-800:oklch(.444 .177 26.899);--color-red-900:oklch(.396 .141 25.723);--color-red-950:oklch(.258 .092 26.042);--color-orange-50:oklch(.98 .016 73.684);--color-orange-100:oklch(.954 .038 75.164);--color-orange-200:oklch(.901 .076 70.697);--color-orange-300:oklch(.837 .128 66.29);--color-orange-400:oklch(.75 .183 55.934);--color-orange-500:oklch(.705 .213 47.604);--color-orange-600:oklch(.646 .222 41.116);--color-orange-700:oklch(.553 .195 38.402);--color-orange-800:oklch(.47 .157 37.304);--color-orange-900:oklch(.408 .123 38.172);--color-orange-950:oklch(.266 .079 36.259);--color-amber-50:oklch(.987 .022 95.277);--color-amber-100:oklch(.962 .059 95.617);--color-amber-200:oklch(.924 .12 95.746);--color-amber-300:oklch(.879 .169 91.605);--color-amber-400:oklch(.828 .189 84.429);--color-amber-500:oklch(.769 .188 70.08);--color-amber-600:oklch(.666 .179 58.318);--color-amber-700:oklch(.555 .163 48.998);--color-amber-800:oklch(.473 .137 46.201);--color-amber-900:oklch(.414 .112 45.904);--color-amber-950:oklch(.279 .077 45.635);--color-yellow-50:oklch(.987 .026 102.212);--color-yellow-100:oklch(.973 .071 103.193);--color-yellow-200:oklch(.945 .129 101.54);--color-yellow-300:oklch(.905 .182 98.111);--color-yellow-400:oklch(.852 .199 91.936);--color-yellow-500:oklch(.795 .184 86.047);--color-yellow-600:oklch(.681 .162 75.834);--color-yellow-700:oklch(.554 .135 66.442);--color-yellow-800:oklch(.476 .114 61.907);--color-yellow-900:oklch(.421 .095 57.708);--color-yellow-950:oklch(.286 .066 53.813);--color-lime-50:oklch(.986 .031 120.757);--color-lime-100:oklch(.967 .067 122.328);--color-lime-200:oklch(.938 .127 124.321);--color-lime-300:oklch(.897 .196 126.665);--color-lime-400:oklch(.841 .238 128.85);--color-lime-500:oklch(.768 .233 130.85);--color-lime-600:oklch(.648 .2 131.684);--color-lime-700:oklch(.532 .157 131.589);--color-lime-800:oklch(.453 .124 130.933);--color-lime-900:oklch(.405 .101 131.063);--color-lime-950:oklch(.274 .072 132.109);--color-green-50:oklch(.982 .018 155.826);--color-green-100:oklch(.962 .044 156.743);--color-green-200:oklch(.925 .084 155.995);--color-green-300:oklch(.871 .15 154.449);--color-green-400:oklch(.792 .209 151.711);--color-green-500:oklch(.723 .219 149.579);--color-green-600:oklch(.627 .194 149.214);--color-green-700:oklch(.527 .154 150.069);--color-green-800:oklch(.448 .119 151.328);--color-green-900:oklch(.393 .095 152.535);--color-green-950:oklch(.266 .065 152.934);--color-emerald-50:oklch(.979 .021 166.113);--color-emerald-100:oklch(.95 .052 163.051);--color-emerald-200:oklch(.905 .093 164.15);--color-emerald-300:oklch(.845 .143 164.978);--color-emerald-400:oklch(.765 .177 163.223);--color-emerald-500:oklch(.696 .17 162.48);--color-emerald-600:oklch(.596 .145 163.225);--color-emerald-700:oklch(.508 .118 165.612);--color-emerald-800:oklch(.432 .095 166.913);--color-emerald-900:oklch(.378 .077 168.94);--color-emerald-950:oklch(.262 .051 172.552);--color-teal-50:oklch(.984 .014 180.72);--color-teal-100:oklch(.953 .051 180.801);--color-teal-200:oklch(.91 .096 180.426);--color-teal-300:oklch(.855 .138 181.071);--color-teal-400:oklch(.777 .152 181.912);--color-teal-500:oklch(.704 .14 182.503);--color-teal-600:oklch(.6 .118 184.704);--color-teal-700:oklch(.511 .096 186.391);--color-teal-800:oklch(.437 .078 188.216);--color-teal-900:oklch(.386 .063 188.416);--color-teal-950:oklch(.277 .046 192.524);--color-cyan-50:oklch(.984 .019 200.873);--color-cyan-100:oklch(.956 .045 203.388);--color-cyan-200:oklch(.917 .08 205.041);--color-cyan-300:oklch(.865 .127 207.078);--color-cyan-400:oklch(.789 .154 211.53);--color-cyan-500:oklch(.715 .143 215.221);--color-cyan-600:oklch(.609 .126 221.723);--color-cyan-700:oklch(.52 .105 223.128);--color-cyan-800:oklch(.45 .085 224.283);--color-cyan-900:oklch(.398 .07 227.392);--color-cyan-950:oklch(.302 .056 229.695);--color-sky-50:oklch(.977 .013 236.62);--color-sky-100:oklch(.951 .026 236.824);--color-sky-200:oklch(.901 .058 230.902);--color-sky-300:oklch(.828 .111 230.318);--color-sky-400:oklch(.746 .16 232.661);--color-sky-500:oklch(.685 .169 237.323);--color-sky-600:oklch(.588 .158 241.966);--color-sky-700:oklch(.5 .134 242.749);--color-sky-800:oklch(.443 .11 240.79);--color-sky-900:oklch(.391 .09 240.876);--color-sky-950:oklch(.293 .066 243.157);--color-blue-50:oklch(.97 .014 254.604);--color-blue-100:oklch(.932 .032 255.585);--color-blue-200:oklch(.882 .059 254.128);--color-blue-300:oklch(.809 .105 251.813);--color-blue-400:oklch(.707 .165 254.624);--color-blue-500:oklch(.623 .214 259.815);--color-blue-600:oklch(.546 .245 262.881);--color-blue-700:oklch(.488 .243 264.376);--color-blue-800:oklch(.424 .199 265.638);--color-blue-900:oklch(.379 .146 265.522);--color-blue-950:oklch(.282 .091 267.935);--color-indigo-50:oklch(.962 .018 272.314);--color-indigo-100:oklch(.93 .034 272.788);--color-indigo-200:oklch(.87 .065 274.039);--color-indigo-300:oklch(.785 .115 274.713);--color-indigo-400:oklch(.673 .182 276.935);--color-indigo-500:oklch(.585 .233 277.117);--color-indigo-600:oklch(.511 .262 276.966);--color-indigo-700:oklch(.457 .24 277.023);--color-indigo-800:oklch(.398 .195 277.366);--color-indigo-900:oklch(.359 .144 278.697);--color-indigo-950:oklch(.257 .09 281.288);--color-violet-50:oklch(.969 .016 293.756);--color-violet-100:oklch(.943 .029 294.588);--color-violet-200:oklch(.894 .057 293.283);--color-violet-300:oklch(.811 .111 293.571);--color-violet-400:oklch(.702 .183 293.541);--color-violet-500:oklch(.606 .25 292.717);--color-violet-600:oklch(.541 .281 293.009);--color-violet-700:oklch(.491 .27 292.581);--color-violet-800:oklch(.432 .232 292.759);--color-violet-900:oklch(.38 .189 293.745);--color-violet-950:oklch(.283 .141 291.089);--color-purple-50:oklch(.977 .014 308.299);--color-purple-100:oklch(.946 .033 307.174);--color-purple-200:oklch(.902 .063 306.703);--color-purple-300:oklch(.827 .119 306.383);--color-purple-400:oklch(.714 .203 305.504);--color-purple-500:oklch(.627 .265 303.9);--color-purple-600:oklch(.558 .288 302.321);--color-purple-700:oklch(.496 .265 301.924);--color-purple-800:oklch(.438 .218 303.724);--color-purple-900:oklch(.381 .176 304.987);--color-purple-950:oklch(.291 .149 302.717);--color-fuchsia-50:oklch(.977 .017 320.058);--color-fuchsia-100:oklch(.952 .037 318.852);--color-fuchsia-200:oklch(.903 .076 319.62);--color-fuchsia-300:oklch(.833 .145 321.434);--color-fuchsia-400:oklch(.74 .238 322.16);--color-fuchsia-500:oklch(.667 .295 322.15);--color-fuchsia-600:oklch(.591 .293 322.896);--color-fuchsia-700:oklch(.518 .253 323.949);--color-fuchsia-800:oklch(.452 .211 324.591);--color-fuchsia-900:oklch(.401 .17 325.612);--color-fuchsia-950:oklch(.293 .136 325.661);--color-pink-50:oklch(.971 .014 343.198);--color-pink-100:oklch(.948 .028 342.258);--color-pink-200:oklch(.899 .061 343.231);--color-pink-300:oklch(.823 .12 346.018);--color-pink-400:oklch(.718 .202 349.761);--color-pink-500:oklch(.656 .241 354.308);--color-pink-600:oklch(.592 .249 .584);--color-pink-700:oklch(.525 .223 3.958);--color-pink-800:oklch(.459 .187 3.815);--color-pink-900:oklch(.408 .153 2.432);--color-pink-950:oklch(.284 .109 3.907);--color-rose-50:oklch(.969 .015 12.422);--color-rose-100:oklch(.941 .03 12.58);--color-rose-200:oklch(.892 .058 10.001);--color-rose-300:oklch(.81 .117 11.638);--color-rose-400:oklch(.712 .194 13.428);--color-rose-500:oklch(.645 .246 16.439);--color-rose-600:oklch(.586 .253 17.585);--color-rose-700:oklch(.514 .222 16.935);--color-rose-800:oklch(.455 .188 13.697);--color-rose-900:oklch(.41 .159 10.272);--color-rose-950:oklch(.271 .105 12.094);--color-slate-50:oklch(.984 .003 247.858);--color-slate-100:oklch(.968 .007 247.896);--color-slate-200:oklch(.929 .013 255.508);--color-slate-300:oklch(.869 .022 252.894);--color-slate-400:oklch(.704 .04 256.788);--color-slate-500:oklch(.554 .046 257.417);--color-slate-600:oklch(.446 .043 257.281);--color-slate-700:oklch(.372 .044 257.287);--color-slate-800:oklch(.279 .041 260.031);--color-slate-900:oklch(.208 .042 265.755);--color-slate-950:oklch(.129 .042 264.695);--color-gray-50:oklch(.985 .002 247.839);--color-gray-100:oklch(.967 .003 264.542);--color-gray-200:oklch(.928 .006 264.531);--color-gray-300:oklch(.872 .01 258.338);--color-gray-400:oklch(.707 .022 261.325);--color-gray-500:oklch(.551 .027 264.364);--color-gray-600:oklch(.446 .03 256.802);--color-gray-700:oklch(.373 .034 259.733);--color-gray-800:oklch(.278 .033 256.848);--color-gray-900:oklch(.21 .034 264.665);--color-gray-950:oklch(.13 .028 261.692);--color-zinc-50:oklch(.985 0 0);--color-zinc-100:oklch(.967 .001 286.375);--color-zinc-200:oklch(.92 .004 286.32);--color-zinc-300:oklch(.871 .006 286.286);--color-zinc-400:oklch(.705 .015 286.067);--color-zinc-500:oklch(.552 .016 285.938);--color-zinc-600:oklch(.442 .017 285.786);--color-zinc-700:oklch(.37 .013 285.805);--color-zinc-800:oklch(.274 .006 286.033);--color-zinc-900:oklch(.21 .006 285.885);--color-zinc-950:oklch(.141 .005 285.823);--color-neutral-50:oklch(.985 0 0);--color-neutral-100:oklch(.97 0 0);--color-neutral-200:oklch(.922 0 0);--color-neutral-300:oklch(.87 0 0);--color-neutral-400:oklch(.708 0 0);--color-neutral-500:oklch(.556 0 0);--color-neutral-600:oklch(.439 0 0);--color-neutral-700:oklch(.371 0 0);--color-neutral-800:oklch(.269 0 0);--color-neutral-900:oklch(.205 0 0);--color-neutral-950:oklch(.145 0 0);--color-stone-50:oklch(.985 .001 106.423);--color-stone-100:oklch(.97 .001 106.424);--color-stone-200:oklch(.923 .003 48.717);--color-stone-300:oklch(.869 .005 56.366);--color-stone-400:oklch(.709 .01 56.259);--color-stone-500:oklch(.553 .013 58.071);--color-stone-600:oklch(.444 .011 73.639);--color-stone-700:oklch(.374 .01 67.558);--color-stone-800:oklch(.268 .007 34.298);--color-stone-900:oklch(.216 .006 56.043);--color-stone-950:oklch(.147 .004 49.25);--color-black:#000;--color-white:#fff;--spacing:.25rem;--breakpoint-sm:40rem;--breakpoint-md:48rem;--breakpoint-lg:64rem;--breakpoint-xl:80rem;--breakpoint-2xl:96rem;--container-3xs:16rem;--container-2xs:18rem;--container-xs:20rem;--container-sm:24rem;--container-md:28rem;--container-lg:32rem;--container-xl:36rem;--container-2xl:42rem;--container-3xl:48rem;--container-4xl:56rem;--container-5xl:64rem;--container-6xl:72rem;--container-7xl:80rem;--text-xs:.75rem;--text-xs--line-height:calc(1/.75);--text-sm:.875rem;--text-sm--line-height:calc(1.25/.875);--text-base:1rem;--text-base--line-height: 1.5 ;--text-lg:1.125rem;--text-lg--line-height:calc(1.75/1.125);--text-xl:1.25rem;--text-xl--line-height:calc(1.75/1.25);--text-2xl:1.5rem;--text-2xl--line-height:calc(2/1.5);--text-3xl:1.875rem;--text-3xl--line-height: 1.2 ;--text-4xl:2.25rem;--text-4xl--line-height:calc(2.5/2.25);--text-5xl:3rem;--text-5xl--line-height:1;--text-6xl:3.75rem;--text-6xl--line-height:1;--text-7xl:4.5rem;--text-7xl--line-height:1;--text-8xl:6rem;--text-8xl--line-height:1;--text-9xl:8rem;--text-9xl--line-height:1;--font-weight-thin:100;--font-weight-extralight:200;--font-weight-light:300;--font-weight-normal:400;--font-weight-medium:500;--font-weight-semibold:600;--font-weight-bold:700;--font-weight-extrabold:800;--font-weight-black:900;--tracking-tighter:-.05em;--tracking-tight:-.025em;--tracking-normal:0em;--tracking-wide:.025em;--tracking-wider:.05em;--tracking-widest:.1em;--leading-tight:1.25;--leading-snug:1.375;--leading-normal:1.5;--leading-relaxed:1.625;--leading-loose:2;--radius-xs:.125rem;--radius-sm:.25rem;--radius-md:.375rem;--radius-lg:.5rem;--radius-xl:.75rem;--radius-2xl:1rem;--radius-3xl:1.5rem;--radius-4xl:2rem;--shadow-2xs:0 1px #0000000d;--shadow-xs:0 1px 2px 0 #0000000d;--shadow-sm:0 1px 3px 0 #0000001a,0 1px 2px -1px #0000001a;--shadow-md:0 4px 6px -1px #0000001a,0 2px 4px -2px #0000001a;--shadow-lg:0 10px 15px -3px #0000001a,0 4px 6px -4px #0000001a;--shadow-xl:0 20px 25px -5px #0000001a,0 8px 10px -6px #0000001a;--shadow-2xl:0 25px 50px -12px #00000040;--inset-shadow-2xs:inset 0 1px #0000000d;--inset-shadow-xs:inset 0 1px 1px #0000000d;--inset-shadow-sm:inset 0 2px 4px #0000000d;--drop-shadow-xs:0 1px 1px #0000000d;--drop-shadow-sm:0 1px 2px #00000026;--drop-shadow-md:0 3px 3px #0000001f;--drop-shadow-lg:0 4px 4px #00000026;--drop-shadow-xl:0 9px 7px #0000001a;--drop-shadow-2xl:0 25px 25px #00000026;--ease-in:cubic-bezier(.4,0,1,1);--ease-out:cubic-bezier(0,0,.2,1);--ease-in-out:cubic-bezier(.4,0,.2,1);--animate-spin:spin 1s linear infinite;--animate-ping:ping 1s cubic-bezier(0,0,.2,1)infinite;--animate-pulse:pulse 2s cubic-bezier(.4,0,.6,1)infinite;--animate-bounce:bounce 1s infinite;--blur-xs:4px;--blur-sm:8px;--blur-md:12px;--blur-lg:16px;--blur-xl:24px;--blur-2xl:40px;--blur-3xl:64px;--perspective-dramatic:100px;--perspective-near:300px;--perspective-normal:500px;--perspective-midrange:800px;--perspective-distant:1200px;--aspect-video:16/9;--default-transition-duration:.15s;--default-transition-timing-function:cubic-bezier(.4,0,.2,1);--default-font-family:var(--font-sans);--default-font-feature-settings:var(--font-sans--font-feature-settings);--default-font-variation-settings:var(--font-sans--font-variation-settings);--default-mono-font-family:var(--font-mono);--default-mono-font-feature-settings:var(--font-mono--font-feature-settings);--default-mono-font-variation-settings:var(--font-mono--font-variation-settings)}}@layer base{*,:after,:before,::backdrop{box-sizing:border-box;border:0 solid;margin:0;padding:0}::file-selector-button{box-sizing:border-box;border:0 solid;margin:0;padding:0}html,:host{-webkit-text-size-adjust:100%;-moz-tab-size:4;tab-size:4;line-height:1.5;font-family:var(--default-font-family,ui-sans-serif,system-ui,sans-serif,"Apple Color Emoji","Segoe UI Emoji","Segoe UI Symbol","Noto Color Emoji");font-feature-settings:var(--default-font-feature-settings,normal);font-variation-settings:var(--default-font-variation-settings,normal);-webkit-tap-highlight-color:transparent}body{line-height:inherit}hr{height:0;color:inherit;border-top-width:1px}abbr:where([title]){-webkit-text-decoration:underline dotted;text-decoration:underline dotted}h1,h2,h3,h4,h5,h6{font-size:inherit;font-weight:inherit}a{color:inherit;-webkit-text-decoration:inherit;text-decoration:inherit}b,strong{font-weight:bolder}code,kbd,samp,pre{font-family:var(--default-mono-font-family,ui-monospace,SFMono-Regular,Menlo,Monaco,Consolas,"Liberation Mono","Courier New",monospace);font-feature-settings:var(--default-mono-font-feature-settings,normal);font-variation-settings:var(--default-mono-font-variation-settings,normal);font-size:1em}small{font-size:80%}sub,sup{vertical-align:baseline;font-size:75%;line-height:0;position:relative}sub{bottom:-.25em}sup{top:-.5em}table{text-indent:0;border-color:inherit;border-collapse:collapse}:-moz-focusring{outline:auto}progress{vertical-align:baseline}summary{display:list-item}ol,ul,menu{list-style:none}img,svg,video,canvas,audio,iframe,embed,object{vertical-align:middle;display:block}img,video{max-width:100%;height:auto}button,input,select,optgroup,textarea{font:inherit;font-feature-settings:inherit;font-variation-settings:inherit;letter-spacing:inherit;color:inherit;opacity:1;background-color:#0000;border-radius:0}::file-selector-button{font:inherit;font-feature-settings:inherit;font-variation-settings:inherit;letter-spacing:inherit;color:inherit;opacity:1;background-color:#0000;border-radius:0}:where(select:is([multiple],[size])) optgroup{font-weight:bolder}:where(select:is([multiple],[size])) optgroup option{padding-inline-start:20px}::file-selector-button{margin-inline-end:4px}::placeholder{opacity:1;color:color-mix(in oklab,currentColor 50%,transparent)}textarea{resize:vertical}::-webkit-search-decoration{-webkit-appearance:none}::-webkit-date-and-time-value{min-height:1lh;text-align:inherit}::-webkit-datetime-edit{display:inline-flex}::-webkit-datetime-edit-fields-wrapper{padding:0}::-webkit-datetime-edit{padding-block:0}::-webkit-datetime-edit-year-field{padding-block:0}::-webkit-datetime-edit-month-field{padding-block:0}::-webkit-datetime-edit-day-field{padding-block:0}::-webkit-datetime-edit-hour-field{padding-block:0}::-webkit-datetime-edit-minute-field{padding-block:0}::-webkit-datetime-edit-second-field{padding-block:0}::-webkit-datetime-edit-millisecond-field{padding-block:0}::-webkit-datetime-edit-meridiem-field{padding-block:0}:-moz-ui-invalid{box-shadow:none}button,input:where([type=button],[type=reset],[type=submit]){-webkit-appearance:button;-moz-appearance:button;appearance:button}::file-selector-button{-webkit-appearance:button;-moz-appearance:button;appearance:button}::-webkit-inner-spin-button{height:auto}::-webkit-outer-spin-button{height:auto}[hidden]:where(:not([hidden=until-found])){display:none!important}}@layer components;@layer utilities{.absolute{position:absolute}.relative{position:relative}.static{position:static}.inset-0{inset:calc(var(--spacing)*0)}.-mt-\[4\.9rem\]{margin-top:-4.9rem}.-mb-px{margin-bottom:-1px}.mb-1{margin-bottom:calc(var(--spacing)*1)}.mb-2{margin-bottom:calc(var(--spacing)*2)}.mb-4{margin-bottom:calc(var(--spacing)*4)}.mb-6{margin-bottom:calc(var(--spacing)*6)}.-ml-8{margin-left:calc(var(--spacing)*-8)}.flex{display:flex}.hidden{display:none}.inline-block{display:inline-block}.inline-flex{display:inline-flex}.table{display:table}.aspect-\[335\/376\]{aspect-ratio:335/376}.h-1{height:calc(var(--spacing)*1)}.h-1\.5{height:calc(var(--spacing)*1.5)}.h-2{height:calc(var(--spacing)*2)}.h-2\.5{height:calc(var(--spacing)*2.5)}.h-3{height:calc(var(--spacing)*3)}.h-3\.5{height:calc(var(--spacing)*3.5)}.h-14{height:calc(var(--spacing)*14)}.h-14\.5{height:calc(var(--spacing)*14.5)}.min-h-screen{min-height:100vh}.w-1{width:calc(var(--spacing)*1)}.w-1\.5{width:calc(var(--spacing)*1.5)}.w-2{width:calc(var(--spacing)*2)}.w-2\.5{width:calc(var(--spacing)*2.5)}.w-3{width:calc(var(--spacing)*3)}.w-3\.5{width:calc(var(--spacing)*3.5)}.w-\[448px\]{width:448px}.w-full{width:100%}.max-w-\[335px\]{max-width:335px}.max-w-none{max-width:none}.flex-1{flex:1}.shrink-0{flex-shrink:0}.translate-y-0{--tw-translate-y:calc(var(--spacing)*0);translate:var(--tw-translate-x)var(--tw-translate-y)}.transform{transform:var(--tw-rotate-x)var(--tw-rotate-y)var(--tw-rotate-z)var(--tw-skew-x)var(--tw-skew-y)}.flex-col{flex-direction:column}.flex-col-reverse{flex-direction:column-reverse}.items-center{align-items:center}.justify-center{justify-content:center}.justify-end{justify-content:flex-end}.gap-3{gap:calc(var(--spacing)*3)}.gap-4{gap:calc(var(--spacing)*4)}:where(.space-x-1>:not(:last-child)){--tw-space-x-reverse:0;margin-inline-start:calc(calc(var(--spacing)*1)*var(--tw-space-x-reverse));margin-inline-end:calc(calc(var(--spacing)*1)*calc(1 - var(--tw-space-x-reverse)))}.overflow-hidden{overflow:hidden}.rounded-full{border-radius:3.40282e38px}.rounded-sm{border-radius:var(--radius-sm)}.rounded-t-lg{border-top-left-radius:var(--radius-lg);border-top-right-radius:var(--radius-lg)}.rounded-br-lg{border-bottom-right-radius:var(--radius-lg)}.rounded-bl-lg{border-bottom-left-radius:var(--radius-lg)}.border{border-style:var(--tw-border-style);border-width:1px}.border-\[\#19140035\]{border-color:#19140035}.border-\[\#e3e3e0\]{border-color:#e3e3e0}.border-black{border-color:var(--color-black)}.border-transparent{border-color:#0000}.bg-\[\#1b1b18\]{background-color:#1b1b18}.bg-\[\#FDFDFC\]{background-color:#fdfdfc}.bg-\[\#dbdbd7\]{background-color:#dbdbd7}.bg-\[\#fff2f2\]{background-color:#fff2f2}.bg-white{background-color:var(--color-white)}.p-6{padding:calc(var(--spacing)*6)}.px-5{padding-inline:calc(var(--spacing)*5)}.py-1{padding-block:calc(var(--spacing)*1)}.py-1\.5{padding-block:calc(var(--spacing)*1.5)}.py-2{padding-block:calc(var(--spacing)*2)}.pb-12{padding-bottom:calc(var(--spacing)*12)}.text-sm{font-size:var(--text-sm);line-height:var(--tw-leading,var(--text-sm--line-height))}.text-\[13px\]{font-size:13px}.leading-\[20px\]{--tw-leading:20px;line-height:20px}.leading-normal{--tw-leading:var(--leading-normal);line-height:var(--leading-normal)}.font-medium{--tw-font-weight:var(--font-weight-medium);font-weight:var(--font-weight-medium)}.text-\[\#1b1b18\]{color:#1b1b18}.text-\[\#706f6c\]{color:#706f6c}.text-\[\#F53003\],.text-\[\#f53003\]{color:#f53003}.text-white{color:var(--color-white)}.underline{text-decoration-line:underline}.underline-offset-4{text-underline-offset:4px}.opacity-100{opacity:1}.shadow-\[0px_0px_1px_0px_rgba\(0\,0\,0\,0\.03\)\,0px_1px_2px_0px_rgba\(0\,0\,0\,0\.06\)\]{--tw-shadow:0px 0px 1px 0px var(--tw-shadow-color,#00000008),0px 1px 2px 0px var(--tw-shadow-color,#0000000f);box-shadow:var(--tw-inset-shadow),var(--tw-inset-ring-shadow),var(--tw-ring-offset-shadow),var(--tw-ring-shadow),var(--tw-shadow)}.shadow-\[inset_0px_0px_0px_1px_rgba\(26\,26\,0\,0\.16\)\]{--tw-shadow:inset 0px 0px 0px 1px var(--tw-shadow-color,#1a1a0029);box-shadow:var(--tw-inset-shadow),var(--tw-inset-ring-shadow),var(--tw-ring-offset-shadow),var(--tw-ring-shadow),var(--tw-shadow)}.\!filter{filter:var(--tw-blur,)var(--tw-brightness,)var(--tw-contrast,)var(--tw-grayscale,)var(--tw-hue-rotate,)var(--tw-invert,)var(--tw-saturate,)var(--tw-sepia,)var(--tw-drop-shadow,)!important}.filter{filter:var(--tw-blur,)var(--tw-brightness,)var(--tw-contrast,)var(--tw-grayscale,)var(--tw-hue-rotate,)var(--tw-invert,)var(--tw-saturate,)var(--tw-sepia,)var(--tw-drop-shadow,)}.transition-all{transition-property:all;transition-timing-function:var(--tw-ease,var(--default-transition-timing-function));transition-duration:var(--tw-duration,var(--default-transition-duration))}.transition-opacity{transition-property:opacity;transition-timing-function:var(--tw-ease,var(--default-transition-timing-function));transition-duration:var(--tw-duration,var(--default-transition-duration))}.delay-300{transition-delay:.3s}.duration-750{--tw-duration:.75s;transition-duration:.75s}.not-has-\[nav\]\:hidden:not(:has(:is(nav))){display:none}.before\:absolute:before{content:var(--tw-content);position:absolute}.before\:top-0:before{content:var(--tw-content);top:calc(var(--spacing)*0)}.before\:top-1\/2:before{content:var(--tw-content);top:50%}.before\:bottom-0:before{content:var(--tw-content);bottom:calc(var(--spacing)*0)}.before\:bottom-1\/2:before{content:var(--tw-content);bottom:50%}.before\:left-\[0\.4rem\]:before{content:var(--tw-content);left:.4rem}.before\:border-l:before{content:var(--tw-content);border-left-style:var(--tw-border-style);border-left-width:1px}.before\:border-\[\#e3e3e0\]:before{content:var(--tw-content);border-color:#e3e3e0}@media (hover:hover){.hover\:border-\[\#1915014a\]:hover{border-color:#1915014a}.hover\:border-\[\#19140035\]:hover{border-color:#19140035}.hover\:border-black:hover{border-color:var(--color-black)}.hover\:bg-black:hover{background-color:var(--color-black)}}@media (width>=64rem){.lg\:-mt-\[6\.6rem\]{margin-top:-6.6rem}.lg\:mb-0{margin-bottom:calc(var(--spacing)*0)}.lg\:mb-6{margin-bottom:calc(var(--spacing)*6)}.lg\:-ml-px{margin-left:-1px}.lg\:ml-0{margin-left:calc(var(--spacing)*0)}.lg\:block{display:block}.lg\:aspect-auto{aspect-ratio:auto}.lg\:w-\[438px\]{width:438px}.lg\:max-w-4xl{max-width:var(--container-4xl)}.lg\:grow{flex-grow:1}.lg\:flex-row{flex-direction:row}.lg\:justify-center{justify-content:center}.lg\:rounded-t-none{border-top-left-radius:0;border-top-right-radius:0}.lg\:rounded-tl-lg{border-top-left-radius:var(--radius-lg)}.lg\:rounded-r-lg{border-top-right-radius:var(--radius-lg);border-bottom-right-radius:var(--radius-lg)}.lg\:rounded-br-none{border-bottom-right-radius:0}.lg\:p-8{padding:calc(var(--spacing)*8)}.lg\:p-20{padding:calc(var(--spacing)*20)}}@media (prefers-color-scheme:dark){.dark\:block{display:block}.dark\:hidden{display:none}.dark\:border-\[\#3E3E3A\]{border-color:#3e3e3a}.dark\:border-\[\#eeeeec\]{border-color:#eeeeec}.dark\:bg-\[\#0a0a0a\]{background-color:#0a0a0a}.dark\:bg-\[\#1D0002\]{background-color:#1d0002}.dark\:bg-\[\#3E3E3A\]{background-color:#3e3e3a}.dark\:bg-\[\#161615\]{background-color:#161615}.dark\:bg-\[\#eeeeec\]{background-color:#eeeeec}.dark\:text-\[\#1C1C1A\]{color:#1c1c1a}.dark\:text-\[\#A1A09A\]{color:#a1a09a}.dark\:text-\[\#EDEDEC\]{color:#ededec}.dark\:text-\[\#F61500\]{color:#f61500}.dark\:text-\[\#FF4433\]{color:#f43}.dark\:shadow-\[inset_0px_0px_0px_1px_\#fffaed2d\]{--tw-shadow:inset 0px 0px 0px 1px var(--tw-shadow-color,#fffaed2d);box-shadow:var(--tw-inset-shadow),var(--tw-inset-ring-shadow),var(--tw-ring-offset-shadow),var(--tw-ring-shadow),var(--tw-shadow)}.dark\:before\:border-\[\#3E3E3A\]:before{content:var(--tw-content);border-color:#3e3e3a}@media (hover:hover){.dark\:hover\:border-\[\#3E3E3A\]:hover{border-color:#3e3e3a}.dark\:hover\:border-\[\#62605b\]:hover{border-color:#62605b}.dark\:hover\:border-white:hover{border-color:var(--color-white)}.dark\:hover\:bg-white:hover{background-color:var(--color-white)}}}@starting-style{.starting\:translate-y-4{--tw-translate-y:calc(var(--spacing)*4);translate:var(--tw-translate-x)var(--tw-translate-y)}}@starting-style{.starting\:translate-y-6{--tw-translate-y:calc(var(--spacing)*6);translate:var(--tw-translate-x)var(--tw-translate-y)}}@starting-style{.starting\:opacity-0{opacity:0}}}@keyframes spin{to{transform:rotate(360deg)}}@keyframes ping{75%,to{opacity:0;transform:scale(2)}}@keyframes pulse{50%{opacity:.5}}@keyframes bounce{0%,to{animation-timing-function:cubic-bezier(.8,0,1,1);transform:translateY(-25%)}50%{animation-timing-function:cubic-bezier(0,0,.2,1);transform:none}}@property --tw-translate-x{syntax:"*";inherits:false;initial-value:0}@property --tw-translate-y{syntax:"*";inherits:false;initial-value:0}@property --tw-translate-z{syntax:"*";inherits:false;initial-value:0}@property --tw-rotate-x{syntax:"*";inherits:false;initial-value:rotateX(0)}@property --tw-rotate-y{syntax:"*";inherits:false;initial-value:rotateY(0)}@property --tw-rotate-z{syntax:"*";inherits:false;initial-value:rotateZ(0)}@property --tw-skew-x{syntax:"*";inherits:false;initial-value:skewX(0)}@property --tw-skew-y{syntax:"*";inherits:false;initial-value:skewY(0)}@property --tw-space-x-reverse{syntax:"*";inherits:false;initial-value:0}@property --tw-border-style{syntax:"*";inherits:false;initial-value:solid}@property --tw-leading{syntax:"*";inherits:false}@property --tw-font-weight{syntax:"*";inherits:false}@property --tw-shadow{syntax:"*";inherits:false;initial-value:0 0 #0000}@property --tw-shadow-color{syntax:"*";inherits:false}@property --tw-inset-shadow{syntax:"*";inherits:false;initial-value:0 0 #0000}@property --tw-inset-shadow-color{syntax:"*";inherits:false}@property --tw-ring-color{syntax:"*";inherits:false}@property --tw-ring-shadow{syntax:"*";inherits:false;initial-value:0 0 #0000}@property --tw-inset-ring-color{syntax:"*";inherits:false}@property --tw-inset-ring-shadow{syntax:"*";inherits:false;initial-value:0 0 #0000}@property --tw-ring-inset{syntax:"*";inherits:false}@property --tw-ring-offset-width{syntax:"<length>";inherits:false;initial-value:0}@property --tw-ring-offset-color{syntax:"*";inherits:false;initial-value:#fff}@property --tw-ring-offset-shadow{syntax:"*";inherits:false;initial-value:0 0 #0000}@property --tw-blur{syntax:"*";inherits:false}@property --tw-brightness{syntax:"*";inherits:false}@property --tw-contrast{syntax:"*";inherits:false}@property --tw-grayscale{syntax:"*";inherits:false}@property --tw-hue-rotate{syntax:"*";inherits:false}@property --tw-invert{syntax:"*";inherits:false}@property --tw-opacity{syntax:"*";inherits:false}@property --tw-saturate{syntax:"*";inherits:false}@property --tw-sepia{syntax:"*";inherits:false}@property --tw-drop-shadow{syntax:"*";inherits:false}@property --tw-duration{syntax:"*";inherits:false}@property --tw-content{syntax:"*";inherits:false;initial-value:""}
            </style>
        @endif    <script src="https://kit.fontawesome.com/your-fontawesome-kit.js" crossorigin="anonymous"></script>
 
    <script src="{{ asset('assets/js/bootstrap.bundle.min.js') }}"></script>
<script src="{{ asset('assets/js/jquery.min.js') }}"></script>
<script src="{{ asset('assets/select2/dist/js/select2.min.js') }}"></script>
    <style>
        @font-face {
            font-family: 'Bellota';
            src: url("{{ asset('assets/css/fonts/Bellota-Regular.ttf') }}") format('truetype');
            font-weight: normal;
            font-style: normal;
        }

        body {
            font-family: 'Bellota', sans-serif;
            padding-top: 60px;
            background-color: #f8f9fa;
        }



        .select2-dropdown {
            z-index: 51 !important;
        }

        .select2-container--default .select2-selection--single {
            height: 46px;
            padding: 0.5rem;
            border: 1px solid #d1d5db;
        }

        .select2-container--default .select2-selection--single .select2-selection__arrow {
            height: 44px;
        }

        .nav-active:hover {
            background: linear-gradient(135deg, #2563eb 0%, #1e40af 100%);
            color: white;
        }

        .nav-item {
            transition: all 0.3s ease;
            border-radius: 8px;
            padding: 0.5rem 1rem;
            margin: 0 0.25rem;
        }

        .nav-item:hover:not(.nav-active) {
            background: rgba(255, 255, 255, 0.1);
            color: #fbbf24;
        }

        .dropdown-menu {
            animation: fadeIn 0.2s ease-in-out;
        }

        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(-10px); }
            to { opacity: 1; transform: translateY(0); }
        }

        .glass-effect {
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.2);
        }

        .mobile-nav-active {
            background: linear-gradient(135deg, #3b82f6 0%, #1d4ed8 100%);
            color: white;
            border-radius: 6px;
            margin: 2px 0;
        }

        /* Améliorations pour les sous-menus */
        .dropdown-group {
            position: relative;
        }

        .dropdown-content {
            opacity: 0;
            visibility: hidden;
            transform: translateY(-10px);
            transition: all 0.3s ease;
            pointer-events: none;
        }

        .dropdown-group:hover .dropdown-content,
        .dropdown-group:focus-within .dropdown-content {
            opacity: 1;
            visibility: visible;
            transform: translateY(0);
            pointer-events: all;
        }

        /* Délai pour éviter la fermeture accidentelle */
        .dropdown-content {
            transition-delay: 0.1s;
        }

        /* Triangle indicateur pour les sous-menus */
        .dropdown-content::before {
            content: '';
            position: absolute;
            top: -6px;
            left: 20px;
            width: 12px;
            height: 12px;
            background: white;
            transform: rotate(45deg);
            border-top: 1px solid rgba(0, 0, 0, 0.1);
            border-left: 1px solid rgba(0, 0, 0, 0.1);
            z-index: 1;
        }

        /* Amélioration pour mobile */
        .mobile-dropdown-content {
            max-height: 0;
            overflow: hidden;
            transition: max-height 0.3s ease;
        }

        .mobile-dropdown-open .mobile-dropdown-content {
            max-height: 500px;
        }
    </style>
</head>

<body class="bg-gray-50">
    <!-- Main Navigation -->
    <nav class="fixed top-0 left-0 w-full bg-gradient-to-r from-gray-900 to-gray-800 text-white shadow-lg z-50 border-b border-gray-700">
        <div class="container mx-auto px-4">
            <div class="flex justify-between items-center py-3">
                <!-- Logo -->
                <div class="flex items-center space-x-3">
                    <div class="w-10 h-10 bg-gradient-to-r from-blue-500 to-purple-600 rounded-lg flex items-center justify-center">
                        <i class="fas fa-store text-white"></i>
                    </div>
                    <span class="text-xl font-bold bg-gradient-to-r from-white to-gray-200 bg-clip-text text-transparent">
                        MonSite
                    </span>
                </div>

                <!-- Desktop Menu -->
                <div id="mainNavbar" class="hidden md:flex items-center space-x-1">
                    <!-- Accueil -->
                    <a href="{{ route('page.accueil') }}" 
                       class="nav-item flex items-center space-x-2 {{ request()->routeIs('page.accueil') ||  request()->routeIs('stat')? 'nav-active' : '' }}">
                        <i class="fas fa-home text-sm"></i>
                        <span>Accueil</span>
                    </a>

                    <!-- Paramétrage d'articles -->
                    <div class="dropdown-group">
                        <button class="nav-item flex items-center space-x-2 {{ request()->routeIs('article.liste') || request()->routeIs('categorie.liste') || request()->routeIs('depense') ? 'nav-active' : '' }}">
                            <i class="fas fa-cogs text-sm"></i>
                            <span>Paramétrage</span>
                            <i class="fas fa-chevron-down text-xs ml-1 transition-transform duration-200 dropdown-group:hover:rotate-180"></i>
                        </button>
                        <div class="dropdown-content absolute left-0 mt-2 w-56 z-50">
                            <div class="glass-effect shadow-xl rounded-lg border border-gray-200">
                                <a href="{{ route('article.liste') }}" 
                                   class="block px-4 py-3 hover:bg-blue-50 text-gray-700 border-b border-gray-100 transition-colors {{ request()->routeIs('article.liste') ? 'bg-blue-50 text-blue-600 font-medium' : '' }}">
                                    <i class="fas fa-glass-martini-alt mr-3 text-blue-500"></i>Boissons
                                </a>
                                <a href="{{ route('categorie.liste') }}" 
                                   class="block px-4 py-3 hover:bg-blue-50 text-gray-700 border-b border-gray-100 transition-colors {{ request()->routeIs('categorie.liste') ? 'bg-blue-50 text-blue-600 font-medium' : '' }}">
                                    <i class="fas fa-tags mr-3 text-green-500"></i>Catégories
                                </a>
                                <div class="border-t border-gray-200 my-1"></div>
                                <!-- <a href="{{ route('depense') }}" 
                                   class="block px-4 py-3 hover:bg-blue-50 text-gray-700 transition-colors {{ request()->routeIs('depense') ? 'bg-blue-50 text-blue-600 font-medium' : '' }}">
                                    <i class="fas fa-money-bill-wave mr-3 text-yellow-500"></i>Dépenses divers
                                </a> -->
                            </div>
                        </div>
                    </div>

                    <!-- Ventes -->
                    <a href="{{ route('commande.liste.vente') }}" 
                       class="nav-item flex items-center space-x-2 {{ request()->routeIs('commande.liste.vente') ? 'nav-active' : '' }}">
                        <i class="fas fa-cart-plus text-sm"></i>
                        <span>Ventes</span>
                    </a>

                    <!-- Achats -->
                    <a href="{{ route('achat.commande') }}" 
                       class="nav-item flex items-center space-x-2 {{ request()->routeIs('achat.commande') ? 'nav-active' : '' }}">
                        <i class="fas fa-shopping-cart text-sm"></i>
                        <span>Achats</span>
                    </a>

                    <!-- Clients & Fournisseurs -->
                    <div class="dropdown-group">
                        <button class="nav-item flex items-center space-x-2 {{ request()->routeIs('client.liste') || request()->routeIs('fournisseur.liste') ? 'nav-active' : '' }}">
                            <i class="fas fa-users text-sm"></i>
                            <span>Clients & Fournisseurs</span>
                            <i class="fas fa-chevron-down text-xs ml-1 transition-transform duration-200 dropdown-group:hover:rotate-180"></i>
                        </button>
                        <div class="dropdown-content absolute left-0 mt-2 w-56 z-50">
                            <div class="glass-effect shadow-xl rounded-lg border border-gray-200">
                                <a href="{{ route('client.liste') }}" 
                                   class="block px-4 py-3 hover:bg-blue-50 text-gray-700 border-b border-gray-100 transition-colors {{ request()->routeIs('client.liste') ? 'bg-blue-50 text-blue-600 font-medium' : '' }}">
                                    <i class="fas fa-users mr-3 text-blue-500"></i>Clients
                                </a>
                                <a href="{{ route('fournisseur.liste') }}" 
                                   class="block px-4 py-3 hover:bg-blue-50 text-gray-700 transition-colors {{ request()->routeIs('fournisseur.liste') ? 'bg-blue-50 text-blue-600 font-medium' : '' }}">
                                    <i class="fas fa-truck mr-3 text-green-500"></i>Fournisseurs
                                </a>
                            </div>
                        </div>
                    </div>

                    <!-- Stock -->
                    <a href="{{ route('stock.liste') }}" 
                       class="nav-item flex items-center space-x-2 {{ request()->routeIs('stock.liste') ? 'nav-active' : '' }}">
                        <i class="fas fa-boxes text-sm"></i>
                        <span>Stock</span>
                    </a>

                    <!-- Paramètres -->
                    <a href="{{ route('parametre') }}" 
                       class="nav-item flex items-center space-x-2 {{ request()->routeIs('parametre') ? 'nav-active' : '' }}">
                        <i class="fas fa-cog text-sm"></i>
                        <span>Paramètres</span>
                    </a>
                </div>

                <!-- User Menu -->
                <div class="dropdown-group">
                    <button class="nav-item flex items-center space-x-2">
                        <i class="fas fa-user-circle text-sm"></i>
                        <span class="max-w-32 truncate">{{ Auth::user()->name }}</span>
                        <i class="fas fa-chevron-down text-xs ml-1 transition-transform duration-200 dropdown-group:hover:rotate-180"></i>
                    </button>
                    <div class="dropdown-content absolute right-0 mt-2 w-48 z-50">
                        <div class="glass-effect shadow-xl rounded-lg border border-gray-200">
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button type="submit" class="block w-full text-left px-4 py-3 hover:bg-red-50 text-gray-700 transition-colors flex items-center">
                                    <i class="fas fa-sign-out-alt mr-3 text-red-500"></i>Se déconnecter
                                </button>
                            </form>
                        </div>
                    </div>
                </div>

                <!-- Mobile Menu Button -->
                <button id="mobile-menu-button" class="md:hidden text-white p-2 rounded-lg hover:bg-gray-700 transition-colors">
                    <i class="fas fa-bars text-lg"></i>
                </button>
            </div>

            <!-- Mobile Menu -->
            <div id="mobile-menu" class="hidden md:hidden bg-gray-800 p-4 mt-3 rounded-lg border border-gray-700">
                <div class="flex flex-col space-y-2">
                    <a href="{{ route('page.accueil') }}" 
                       class="flex items-center space-x-3 px-3 py-2 rounded-lg transition-colors {{ request()->routeIs('page.accueil') ? 'mobile-nav-active' : 'hover:bg-gray-700' }}">
                        <i class="fas fa-home w-5 text-center"></i>
                        <span>Accueil</span>
                    </a>

                    <!-- Paramétrage Mobile -->
                    <div class="mobile-dropdown-group">
                        <button class="mobile-dropdown-toggle flex items-center justify-between w-full px-3 py-2 rounded-lg transition-colors hover:bg-gray-700">
                            <div class="flex items-center space-x-3">
                                <i class="fas fa-cogs w-5 text-center"></i>
                                <span>Paramétrage</span>
                            </div>
                            <i class="fas fa-chevron-down text-xs transition-transform duration-200"></i>
                        </button>
                        <div class="mobile-dropdown-content ml-6">
                            <a href="{{ route('article.liste') }}" 
                               class="flex items-center space-x-3 px-3 py-2 rounded-lg transition-colors {{ request()->routeIs('article.liste') ? 'mobile-nav-active' : 'hover:bg-gray-700' }}">
                                <i class="fas fa-glass-martini-alt w-5 text-center"></i>
                                <span>Boissons</span>
                            </a>
                            <a href="{{ route('categorie.liste') }}" 
                               class="flex items-center space-x-3 px-3 py-2 rounded-lg transition-colors {{ request()->routeIs('categorie.liste') ? 'mobile-nav-active' : 'hover:bg-gray-700' }}">
                                <i class="fas fa-tags w-5 text-center"></i>
                                <span>Catégories</span>
                            </a>
                            <a href="{{ route('depense') }}" 
                               class="flex items-center space-x-3 px-3 py-2 rounded-lg transition-colors {{ request()->routeIs('depense') ? 'mobile-nav-active' : 'hover:bg-gray-700' }}">
                                <i class="fas fa-money-bill-wave w-5 text-center"></i>
                                <span>Dépenses divers</span>
                            </a>
                        </div>
                    </div>

                    <!-- Ventes & Achats -->
                    <a href="{{ route('commande.liste.vente') }}" 
                       class="flex items-center space-x-3 px-3 py-2 rounded-lg transition-colors {{ request()->routeIs('commande.liste.vente') ? 'mobile-nav-active' : 'hover:bg-gray-700' }}">
                        <i class="fas fa-cart-plus w-5 text-center"></i>
                        <span>Ventes</span>
                    </a>
                    <a href="{{ route('achat.commande') }}" 
                       class="flex items-center space-x-3 px-3 py-2 rounded-lg transition-colors {{ request()->routeIs('achat.commande') ? 'mobile-nav-active' : 'hover:bg-gray-700' }}">
                        <i class="fas fa-shopping-cart w-5 text-center"></i>
                        <span>Achats</span>
                    </a>

                    <!-- Clients & Fournisseurs Mobile -->
                    <div class="mobile-dropdown-group">
                        <button class="mobile-dropdown-toggle flex items-center justify-between w-full px-3 py-2 rounded-lg transition-colors hover:bg-gray-700">
                            <div class="flex items-center space-x-3">
                                <i class="fas fa-users w-5 text-center"></i>
                                <span>Clients & Fournisseurs</span>
                            </div>
                            <i class="fas fa-chevron-down text-xs transition-transform duration-200"></i>
                        </button>
                        <div class="mobile-dropdown-content ml-6">
                            <a href="{{ route('client.liste') }}" 
                               class="flex items-center space-x-3 px-3 py-2 rounded-lg transition-colors {{ request()->routeIs('client.liste') ? 'mobile-nav-active' : 'hover:bg-gray-700' }}">
                                <i class="fas fa-users w-5 text-center"></i>
                                <span>Clients</span>
                            </a>
                            <a href="{{ route('fournisseur.liste') }}" 
                               class="flex items-center space-x-3 px-3 py-2 rounded-lg transition-colors {{ request()->routeIs('fournisseur.liste') ? 'mobile-nav-active' : 'hover:bg-gray-700' }}">
                                <i class="fas fa-truck w-5 text-center"></i>
                                <span>Fournisseurs</span>
                            </a>
                        </div>
                    </div>

                    <!-- Stock & Paramètres -->
                    <a href="{{ route('stock.liste') }}" 
                       class="flex items-center space-x-3 px-3 py-2 rounded-lg transition-colors {{ request()->routeIs('stock.liste') ? 'mobile-nav-active' : 'hover:bg-gray-700' }}">
                        <i class="fas fa-boxes w-5 text-center"></i>
                        <span>Stock</span>
                    </a>
                    <a href="{{ route('parametre') }}" 
                       class="flex items-center space-x-3 px-3 py-2 rounded-lg transition-colors {{ request()->routeIs('parametre') ? 'mobile-nav-active' : 'hover:bg-gray-700' }}">
                        <i class="fas fa-cog w-5 text-center"></i>
                        <span>Paramètres</span>
                    </a>
                </div>
            </div>
        </div>
    </nav>


    <!-- Main Content -->
    <div class="max-w-7xl mx-auto px-10 py-6">
        <div class="bg-white shadowrounded-md rounded-md overflow-hidden">
            <!-- Header -->
            <div class="bg-white border-b-2 border-gray-200 py-4 px-6 flex justify-between items-center">
                <h5 class="textrounded-md font-semibold flex items-center text-gray-800">
                    <svg class="w-5 h-5 mr-2 text-gray-600" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a1 1 0 100 2 1 1 0 000-2zm-10 2H3" />
                    </svg>
                    Nouvel achat
                </h5>
                <a href="{{ url()->previous() }}" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-md text-sm flex items-center transition-colors">
                    <svg class="w-4 h-4 mr-1" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                    </svg>
                    Retour
                </a>
            </div>


            <!-- Messages d'erreur -->
            @if(session('error') || $errors->any())
            <div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-4 mb-4 flex justify-between items-center">
                <div>
                    <strong>Erreur!</strong> {{ session('error') ?? 'Veuillez remplir tous les champs requis.' }}
                </div>
                <button onclick="this.parentElement.style.display='none'" class="text-red-700 hover:text-red-900">
                    <i class="fas fa-times"></i>
                </button>
            </div>
            @endif

            <!-- Formulaire -->
            <form id="achatForm" method="POST" action="{{ route('achat.store') }}">
                @csrf
                <div class="bg-white p-6 roundedrounded-md shadow-sm border-2 border-gray-300 max-w-7xl mx-auto my-3">
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                        <!-- Numéro de commande -->
                        <div>
                            <label class="flex items-center text-sm font-semibold text-gray-700 mb-1">
                                <svg class="w-5 h-5 mr-1 text-gray-500" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                                </svg>
                                Numéro de commande
                            </label>
                            <input type="text" name="numero" class="w-full border border-gray-200 rounded-md px-3 py-2 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors" required>
                        </div>

                        <!-- Date -->
                        <div>
                            <label class="flex items-center text-sm font-semibold text-gray-700 mb-1">
                                <svg class="w-5 h-5 mr-1 text-gray-500" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                </svg>
                                Date
                            </label>
                            <input type="date" name="dateachat" value="{{ date('Y-m-d') }}" class="w-full border border-gray-200 rounded-md px-3 py-2 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors" required>
                        </div>

                        <!-- Fournisseur -->
                        <div>
                            <label class="flex items-center text-sm font-semibold text-gray-700 mb-1">
                                <svg class="w-5 h-5 mr-1 text-gray-500" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" />
                                </svg>
                                Fournisseur
                            </label>
                            <select name="fournisseur_id" class="w-full border border-gray-200 rounded-md px-3 py-2 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors select2" required>
                                @foreach($fournisseurs as $fournisseur)
                                <option value="{{ $fournisseur->id }}">{{ $fournisseur->nom }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>

                <!-- Tableau articles -->
                <div class="overflow-x-auto mb-4">
                    <table class="w-full table-auto border border-gray-100 rounded-md bg-white">
                        <thead class="bg-gray-50 text-dark rounded-md">
                            <tr>
                                <th class="p-1 border border-gray-300">Article</th>
                                <th class="p-1 border border-gray-300">Quantité (Cageot/Pack)</th>
                                <th class="p-1 border border-gray-300">Quantité (Unité)</th>
                                <th class="p-1 border border-gray-300">Total (Ar)</th>
                                <th class="p-1 border border-gray-300">Prix unité (Ar)</th>
                                <th class="p-1 border border-gray-300">Action</th>
                            </tr>
                        </thead>
                        <tbody id="articlesContainer" class="divide-y divide-gray-400">
    <tr class="article-row hover:bg-gray-50">
        <td class="p-3 border border-gray-400">
            <select class="w-full border border-gray-400 px-3 py-2 focus:outline-none focus:border-blue-500 select2 article-select" data-index="0">
                @foreach($articles as $article)
                <option value="{{ $article->id }}"
                    data-prix="{{ $article->prix_achat }}"
                    data-condi="{{ $article->conditionnement }}"
                    data-prixcgt="{{ $article->prix_cgt }}"
                    data-consignation="{{ $article->prix_consignation }}">
                    {{ $article->nom }}
                </option>
                @endforeach
            </select>
        </td>
        <td class="p-3 border border-gray-400">
            <input type="number" class="w-full border border-gray-400 px-3 py-2 focus:outline-none focus:border-blue-500 quantite-input" data-index="0" min="1">
        </td>
        <td class="p-3 border border-gray-400">
            <input type="number" class="w-full border border-gray-400 px-3 py-2 focus:outline-none focus:border-blue-500 quantiteunite-input" data-index="0" min="1">
        </td>
        <td class="p-3 border border-gray-400">
            <input type="number" class="w-full border border-gray-400 px-3 py-2  total-input" data-index="0">
        </td>
        <td class="p-3 border border-gray-400">
            <input type="number" class="w-full border border-gray-400 px-3 py-2 bg-gray-100 prixunite-input" data-index="0" min="1" step="0.01" readonly>
        </td>
        <td class="p-3 text-center border border-gray-400">
            <button type="button" class="text-red-500 hover:text-red-700 remove-article" data-index="0">
                <i class="fas fa-trash"></i>
            </button>
        </td>
    </tr>
</tbody>
                    </table>
                </div>


                <!-- Ajouter article + Total -->
                <div class="flex justify-between items-center mb-4">
                    <button type="button" class="bg-blue-600 text-white px-4 py-2 rounded-md hover:bg-blue-700 flex items-center" id="ajouterArticleBtn">
                        <i class="fas fa-plus mr-2"></i>Ajouter un article
                    </button>
                    <div class="textrounded-md font-bold text-green-600">
                        <span id="grandTotal">0</span> Ar
                    </div>
                </div>

                <!-- Bouton valider -->
                <div class="flex justify-end px-4 mb-4">
                    <button type="button" class="bg-blue-600 text-white px-4 py-2 rounded-md hover:bg-blue-700 flex items-center" id="validerCommande">
                        <i class="fas fa-check-circle mr-2"></i>Valider la commande
                    </button>
                </div>
                <div id="hiddenInputs"></div>
            </form>
        </div>

        <!-- Modal confirmation -->
        <div id="validationModal" class="fixed inset-0 bg-black bg-opacity-50 hidden flex items-center justify-center z-50">
            <div class="bg-white rounded-md shadowrounded-md max-w-md w-full">
                <div class="bg-gray-800 text-white p-4 flex justify-between items-center -trounded-md">
                    <h5 class="textrounded-md font-bold flex items-center"><i class="fas fa-check-circle mr-2"></i>Confirmation de commande</h5>
                    <button onclick="closeModal('validationModal')" class="text-white hover:text-gray-200"><i class="fas fa-times"></i></button>
                </div>
                <div class="p-4 text-center">
                    <i class="fas fa-question-circle text-4xl text-yellow-500 mb-4"></i>
                    <h5 class="textrounded-md font-bold mb-4">Voulez-vous valider cette commande ?</h5>
                    <div class="bg-gray-100 p-2 rounded-md flex justify-between items-center">
                        <span class="font-bold">Montant total:</span>
                        <div><span class="textrounded-md font-bold text-gray-800" id="modalTotal">0</span><span class="ml-2">Ar</span></div>
                    </div>
                </div>
                <div class="bg-gray-100 p-4 -brounded-md flex justify-end gap-2">
                    <button type="button" onclick="closeModal('validationModal')" class="bg-gray-500 text-white px-4 py-2 rounded-md hover:bg-gray-600 flex items-center">
                        <i class="fas fa-times mr-2"></i>Annuler
                    </button>
                    <button type="button" class="bg-gray-800 text-white px-4 py-2 rounded-md hover:bg-gray-900 flex items-center" id="confirmSubmit">
                        <i class="fas fa-check mr-2"></i>Confirmer
                    </button>
                </div>
            </div>
        </div>
    </div>


    <script>
        function toggleNavbar() {
            document.getElementById('mainNavbar').classList.toggle('hidden');
        }

        function openModal(modalId) {
            document.getElementById(modalId).classList.remove('hidden');
        }

        function closeModal(modalId) {
            document.getElementById(modalId).classList.add('hidden');
        }

        $(document).ready(function() {
            $('.select2').select2();

            let articleIndex = 0;

            function calculatePricePerUnit(index) {
                const quantiteCageot = parseFloat($(`.quantite-input[data-index="${index}"]`).val()) || 0;
                const quantiteUnite = parseFloat($(`.quantiteunite-input[data-index="${index}"]`).val()) || 0;
                const total = parseFloat($(`.total-input[data-index="${index}"]`).val()) || 0;
                const selectedOption = $(`.article-select[data-index="${index}"] option:selected`);
                const conditionnement = parseFloat(selectedOption.data('condi')) || 1;

                let prixUnite = 0;
                if (quantiteCageot > 0) {
                    prixUnite = total / (quantiteCageot * conditionnement);
                } else if (quantiteUnite > 0) {
                    prixUnite = total / quantiteUnite;
                }

                if (prixUnite > 0) {
                    $(`.prixunite-input[data-index="${index}"]`).val(prixUnite.toFixed(2));
                } else {
                    $(`.prixunite-input[data-index="${index}"]`).val('');
                }

                updateGrandTotal();
            }

            function updateGrandTotal() {
                let grandTotal = 0;
                $('.total-input').each(function() {
                    grandTotal += parseFloat($(this).val()) || 0;
                });
                $('#grandTotal').text(grandTotal.toFixed(2));
                $('#modalTotal').text(grandTotal.toFixed(2));
            }

            function handleQuantiteExclusivity(index) {
                const quantiteCageot = $(`.quantite-input[data-index="${index}"]`);
                const quantiteUnite = $(`.quantiteunite-input[data-index="${index}"]`);

                if (quantiteCageot.val() && quantiteCageot.val() > 0) {
                    quantiteUnite.val('').prop('disabled', true);
                } else if (quantiteUnite.val() && quantiteUnite.val() > 0) {
                    quantiteCageot.val('').prop('disabled', true);
                } else {
                    quantiteCageot.prop('disabled', false);
                    quantiteUnite.prop('disabled', false);
                }
            }

            $(document).on('input', '.quantite-input, .quantiteunite-input, .total-input', function() {
                const index = $(this).data('index');
                handleQuantiteExclusivity(index);
                calculatePricePerUnit(index);
            });

            $(document).on('change', '.article-select', function() {
                const index = $(this).data('index');
                $(`.prixunite-input[data-index="${index}"]`).val('');
                const currentTotal = $(`.total-input[data-index="${index}"]`).val() || '';
                $(`.total-input[data-index="${index}"]`).val(currentTotal);
                updateGrandTotal();
            });

            $('#ajouterArticleBtn').click(function() {
                articleIndex++;
                const newRow = `
                        <tr class="article-row hover:bg-gray-100">
    <td class="p-3 border border-gray-400">
        <select class="w-full border border-gray-400 px-3 py-2 focus:outline-none focus:border-blue-500 select2 article-select" data-index="${articleIndex}">
            @foreach($articles as $article)
            <option value="{{ $article->id }}"
                    data-prix="{{ $article->prix_achat }}"
                    data-condi="{{ $article->conditionnement }}"
                    data-prixcgt="{{ $article->prix_cgt }}"
                    data-consignation="{{ $article->prix_consignation }}">
                {{ $article->nom }}
            </option>
            @endforeach
        </select>
    </td>
    <td class="p-3 border border-gray-400">
        <input type="number" class="w-full border border-gray-400 px-3 py-2 focus:outline-none focus:border-blue-500 quantite-input" data-index="${articleIndex}" min="1">
    </td>
    <td class="p-3 border border-gray-400">
        <input type="number" class="w-full border border-gray-400 px-3 py-2 focus:outline-none focus:border-blue-500 quantiteunite-input" data-index="${articleIndex}" min="1">
    </td>
    <td class="p-3 border border-gray-400">
        <input type="number" class="w-full border border-gray-400 px-3 py-2  total-input" data-index="${articleIndex}">
    </td>
    <td class="p-3 border border-gray-400">
        <input type="number" class="w-full border border-gray-400 px-3 py-2 bg-gray-100 prixunite-input" data-index="${articleIndex}" min="1" step="0.01" readonly>
    </td>
    <td class="p-3 text-center border border-gray-400">
        <button type="button" class="text-red-500 hover:text-red-700 remove-article" data-index="${articleIndex}">
            <i class="fas fa-trash"></i>
        </button>
    </td>
</tr>
`;
                $('#articlesContainer').append(newRow);
                $(`.article-select[data-index="${articleIndex}"]`).select2();
                handleQuantiteExclusivity(articleIndex);
            });

            $(document).on('click', '.remove-article', function() {
                $(this).closest('.article-row').remove();
                updateGrandTotal();
            });

            $('#validerCommande').click(function() {
                let isValid = true;
                $('.article-row').each(function() {
                    const index = $(this).find('.article-select').data('index');
                    const quantite = $(this).find('.quantite-input').val();
                    const quantiteunite = $(this).find('.quantiteunite-input').val();
                    const total = $(this).find('.total-input').val();

                    if ((!quantite || quantite <= 0) && (!quantiteunite || quantiteunite <= 0) || !total || total <= 0) {
                        isValid = false;
                        return false;
                    }
                });

                if (!isValid) {
                    alert("Veuillez remplir tous les champs requis pour chaque article (quantité et total)");
                    return;
                }

                prepareHiddenInputs();
                openModal('validationModal');
            });

            let isSubmitting = false;

            $('#confirmSubmit').click(function() {
                if (isSubmitting) return;
                isSubmitting = true;
                const button = this;
                button.disabled = true;
                button.innerHTML = '<i class="fas fa-spinner fa-spin mr-2"></i>Traitement...';
                setTimeout(() => {
                    $('#achatForm').submit();
                }, 50);
            });

            function prepareHiddenInputs() {
                $('#hiddenInputs').empty();
                $('.article-row').each(function(index) {
                    const sectionIndex = $(this).find('.article-select').data('index');
                    const articleId = $(this).find('.article-select').val();
                    const quantite = $(this).find('.quantite-input').val();
                    const quantiteunite = $(this).find('.quantiteunite-input').val();
                    const prixUnite = $(this).find('.prixunite-input').val();
                    const total = $(this).find('.total-input').val();

                    $('#hiddenInputs').append(`
                        <input type="hidden" name="articles[]" value="${articleId}">
                        <input type="hidden" name="quantites[]" value="${quantite}">
                        <input type="hidden" name="quantitesunite[]" value="${quantiteunite ? quantiteunite : 0}">
                        <input type="hidden" name="prices[]" value="${prixUnite}">
                        <input type="hidden" name="totals[]" value="${total}">
                    `);
                });
                $('#hiddenInputs').append(`
                    <input type="hidden" name="numero_commande" value="${$('#numero_commande').val()}">
                `);
            }

            handleQuantiteExclusivity(0);
        });
    </script>
</body>

</html>