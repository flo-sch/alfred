var logo = Snap('logo');

console.log('logo', logo);

Snap.load('/bundles/fsbalfreddashboard/images/alfred-logo.svg', function (f) {
    console.log(f);
});
