# Slots in Neos Fusion
Define slots in your components and pass content to fill them.  
Inspired by [Laravel Blade](https://laravel.com/docs/8.x/blade#slots).

## Installation
Add `"beromir/neos-slots": "1.0.0-beta.2"` to your `composer.json` file.

## Requirements
- PHP 8.0 and up
- Neos 7.0 and up

## Usage

### Example: Columns Component
Define slots with `<x-slot name="name-of-the-slot"/>`.  
Add the processor to the renderer with `renderer.@process.slots = Beromir.Slots:Slots`.

`Columns.fusion:`
```html
prototype(Vendor.Site:Columns) < prototype(Neos.Fusion:Component) {
    renderer = afx`
        <div class="grid grid-cols-2 gap-4">
            <div class="bg-gray-50">
                <x-slot name="col-1"/>
            </div>
            <div class="bg-gray-50">
                <x-slot name="col-2"/>
            </div>
        </div>
    `
    renderer.@process.slots = Beromir.Slots:Slots
}
```

Pass the content to the slots:
```html
<x-slot target="name-of-the-defined-slot">
    <h1>Hello World!</h1>
</x-slot>
```

`Content.fusion:`
```html
prototype(Vendor.Site:Content) < prototype(Neos.Neos:ContentComponent) {

    renderer = afx`
        <Vendor.Site:Columns>
            <x-slot target="col-1">
                <p>
                    Lorem ipsum dolor sit amet, consectetur adipisicing elit. Accusamus assumenda at blanditiis
                    eligendi excepturi illo impedit in laudantium magnam, minus, nostrum nulla numquam
                    perspiciatis
                    praesentium quo sint vel voluptatem voluptatum?
                </p>
            </x-slot>
            <x-slot target="col-2">
                <p>
                    Lorem ipsum dolor sit amet, consectetur adipisicing elit. Accusamus assumenda at blanditiis
                    eligendi excepturi illo impedit in laudantium magnam, minus, nostrum nulla numquam
                    perspiciatis
                    praesentium quo sint vel voluptatem voluptatum?
                </p>
            </x-slot>
        </Vendor.Site:Columns>
    `
}

```

`HTML output:`
```html
<div class="grid grid-cols-2 gap-4">
    <div class="bg-gray-50">
        <p>
            Lorem ipsum dolor sit amet, consectetur adipisicing elit. Accusamus assumenda at blanditiis
            eligendi excepturi illo impedit in laudantium magnam, minus, nostrum nulla numquam
            perspiciatis
            praesentium quo sint vel voluptatem voluptatum?
        </p>
    </div>
    <div class="bg-gray-50">
        <p>
            Lorem ipsum dolor sit amet, consectetur adipisicing elit. Accusamus assumenda at blanditiis
            eligendi excepturi illo impedit in laudantium magnam, minus, nostrum nulla numquam
            perspiciatis
            praesentium quo sint vel voluptatem voluptatum?
        </p>
    </div>
</div>
```

### Default Slot
The default slot does not need a name:
```html
<x-slot/>
```

To fill the default slot with content, you do not need to use `<x-slot target="foo">`:
```html
<Vendor.Site:Columns>
    <p>
        This will be passed into the default slot.
    </p>
</Vendor.Site:Columns>
```

#### Columns example with a default slot
`Columns.fusion:`
```html
prototype(Vendor.Site:Columns) < prototype(Neos.Fusion:Component) {
    renderer = afx`
        <div class="grid grid-cols-2 gap-4">
            <div class="bg-gray-50">
                // default slot
                <x-slot/>
            </div>
            <div class="bg-gray-50">
                <x-slot name="col-2"/>
            </div>
        </div>
    `
    renderer.@process.slots = Beromir.Slots:Slots
}
```

`Content.fusion:`
```html
prototype(Vendor.Site:Content) < prototype(Neos.Neos:ContentComponent) {

    renderer = afx`
        <Vendor.Site:Columns>
            // content for the default slot
            <p>
                Lorem ipsum dolor sit amet, consectetur adipisicing elit. Accusamus assumenda at blanditiis
                eligendi excepturi illo impedit in laudantium magnam, minus, nostrum nulla numquam
                perspiciatis
                praesentium quo sint vel voluptatem voluptatum?
            </p>
            // content for the other slot
            <x-slot target="col-2">
                <p>
                    Lorem ipsum dolor sit amet, consectetur adipisicing elit. Accusamus assumenda at blanditiis
                    eligendi excepturi illo impedit in laudantium magnam, minus, nostrum nulla numquam
                    perspiciatis
                    praesentium quo sint vel voluptatem voluptatum?
                </p>
            </x-slot>
        </Vendor.Site:Columns>
    `
}
```

### Default Content
You can add content to a slot that is displayed when no data is passed to the slot.

```html
<x-slot name="slot-with-default-content">
    <p>This is displayed when no data is passed to the slot.</p>
</x-slot>
```
