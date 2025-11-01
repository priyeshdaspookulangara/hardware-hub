<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>WYSIWYG Editor</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .CommentBox-toolbar .Button--invisible {
            color: var(--fgColor-muted, var(--color-fg-muted));
        }
        .Button--invisible.Button--iconOnly {
            color: var(--button-invisible-iconColor-rest, var(--color-fg-muted));
        }
        .Button.Button--iconOnly {
            color: var(--fgColor-muted);
        }
        .Button--iconOnly {
            display: inline-grid;
            padding: unset;
            place-content: center;
            width: var(--control-medium-size);
        }
        .Button--invisible {
            color: var(--button-invisible-fgColor-rest);
        }
        .Button {
            align-items: center;
            background-color: initial;
            border: var(--borderWidth-thin) solid;
            border-color: rgba(0, 0, 0, 0);
            border-radius: var(--borderRadius-medium);
            color: var(--button-default-fgColor-rest);
            cursor: pointer;
            display: inline-flex;
            flex-direction: row;
            font-size: var(--text-body-size-medium);
            font-weight: var(--base-text-weight-medium);
            gap: var(--base-size-4);
            height: var(--control-medium-size);
            justify-content: space-between;
            min-width: max-content;
            padding: 0 var(--control-medium-paddingInline-normal);
            position: relative;
            text-align: center;
            transition: var(--duration-fast) var(--easing-easeInOut);
            transition-property: color, fill, background-color, border-color;
            -webkit-user-select: none;
            user-select: none;
        }
        * {
            box-sizing: border-box;
        }
        button, html [type=button], [type=reset], [type=submit] {
            -webkit-appearance: button;
        }
        button {
            cursor: pointer;
            border-radius: 0;
        }
        input, select, textarea, button {
            font-family: inherit;
            font-size: inherit;
            line-height: inherit;
        }
        .ActionBar-item-container {
            display: flex;
        }
        .octicon {
            fill: currentColor;
        }
    </style>
</head>
<body>
