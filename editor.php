<?php
include 'editor_header.php';
?>

<div class="container mt-5">
    <h2 class="mb-4">WYSIWYG Editor</h2>
    <div id="editor-container">
        <div data-target="action-bar.itemContainer" data-view-component="true" class="ActionBar-item-container">
            <div data-targets="action-bar.items" data-view-component="true" class="ActionBar-item" style="visibility: visible;"><button id="action-bar-5bbf6d0e-3532-4b04-8aab-1a845f1e4d28" data-md-button="header-3" type="button" class="Button Button--iconOnly Button--invisible Button--medium"> <svg aria-hidden="true" height="16" viewBox="0 0 16 16" version="1.1" width="16" data-view-component="true" class="octicon octicon-heading Button-visual"><path d="M3.75 2a.75.75 0 0 1 .75.75V7h7V2.75a.75.75 0 0 1 1.5 0v10.5a.75.75 0 0 1-1.5 0V8.5h-7v4.75a.75.75 0 0 1-1.5 0V2.75A.75.75 0 0 1 3.75 2Z"></path></svg></button></div>
            <div data-targets="action-bar.items" data-view-component="true" class="ActionBar-item" style="visibility: visible;"><button id="action-bar-91e22fef-551e-4cb9-b99d-641aec4546d4" data-md-button="bold" type="button" class="Button Button--iconOnly Button--invisible Button--medium"> <svg aria-hidden="true" height="16" viewBox="0 0 16 16" version="1.1" width="16" data-view-component="true" class="octicon octicon-bold Button-visual"><path d="M4 2h4.5a3.501 3.501 0 0 1 2.852 5.53A3.499 3.499 0 0 1 9.5 14H4a1 1 0 0 1-1-1V3a1 1 0 0 1 1-1Zm1 7v3h4.5a1.5 1.5 0 0 0 0-3Zm3.5-2a1.5 1.5 0 0 0 0-3H5v3Z"></path></svg></button></div>
            <div data-targets="action-bar.items" data-view-component="true" class="ActionBar-item" style="visibility: visible;"><button id="action-bar-3bfeac06-1017-4177-a9ff-5f5594b5a99f" data-md-button="italic" type="button" class="Button Button--iconOnly Button--invisible Button--medium"> <svg aria-hidden="true" height="16" viewBox="0 0 16 16" version="1.1" width="16" data-view-component="true" class="octicon octicon-italic Button-visual"><path d="M6 2.75A.75.75 0 0 1 6.75 2h6.5a.75.75 0 0 1 0 1.5h-2.505l-3.858 9H9.25a.75.75 0 0 1 0 1.5h-6.5a.75.75 0 0 1 0-1.5h2.505l3.858-9H6.75A.75.75 0 0 1 6 2.75Z"></path></svg></button></div>
            <div data-targets="action-bar.items" data-view-component="true" class="ActionBar-item" style="visibility: visible;"><button id="action-bar-edbbd220-dda5-40cd-a0c2-9eff982bdc17" data-md-button="quote" type="button" class="Button Button--iconOnly Button--invisible Button--medium"> <svg aria-hidden="true" height="16" viewBox="0 0 16 16" version="1.1" width="16" data-view-component="true" class="octicon octicon-quote Button-visual"><path d="M1.75 2.5h10.5a.75.75 0 0 1 0 1.5H1.75a.75.75 0 0 1 0-1.5Zm4 5h8.5a.75.75 0 0 1 0 1.5h-8.5a.75.75 0 0 1 0-1.5Zm0 5h8.5a.75.75 0 0 1 0 1.5h-8.5a.75.75 0 0 1 0-1.5ZM2.5 7.75v6a.75.75 0 0 1-1.5 0v-6a.75.75 0 0 1 1.5 0Z"></path></svg></button></div>
            <div data-targets="action-bar.items" data-view-component="true" class="ActionBar-item" style="visibility: visible;"><button id="action-bar-f9bf4781-2ca6-4137-9247-8904db1afdc0" data-md-button="code" type="button" class="Button Button--iconOnly Button--invisible Button--medium"> <svg aria-hidden="true" height="16" viewBox="0 0 16 16" version="1.1" width="16" data-view-component="true" class="octicon octicon-code Button-visual"><path d="m11.28 3.22 4.25 4.25a.75.75 0 0 1 0 1.06l-4.25 4.25a.749.749 0 0 1-1.275-.326.749.749 0 0 1 .215-.734L13.94 8l-3.72-3.72a.749.749 0 0 1 .326-1.275.749.749 0 0 1 .734.215Zm-6.56 0a.751.751 0 0 1 1.042.018.751.751 0 0 1 .018 1.042L2.06 8l3.72 3.72a.749.749 0 0 1-.326 1.275.749.749 0 0 1-.734-.215L.47 8.53a.75.75 0 0 1 0-1.06Z"></path></svg></button></div>
            <div data-targets="action-bar.items" data-view-component="true" class="ActionBar-item" style="visibility: visible;"><button id="action-bar-98f6ddf1-0a6c-4120-b13b-35ca1f8e2191" data-md-button="link" type="button" class="Button Button--iconOnly Button--invisible Button--medium"> <svg aria-hidden="true" height="16" viewBox="0 0 16 16" version="1.1" width="16" data-view-component="true" class="octicon octicon-link Button-visual"><path d="m7.775 3.275 1.25-1.25a3.5 3.5 0 1 1 4.95 4.95l-2.5 2.5a3.5 3.5 0 0 1-4.95 0 .751.751 0 0 1 .018-1.042.751.751 0 0 1 1.042-.018 1.998 1.998 0 0 0 2.83 0l2.5-2.5a2.002 2.002 0 0 0-2.83-2.83l-1.25 1.25a.751.751 0 0 1-1.042-.018.751.751 0 0 1-.018-1.042Zm-4.69 9.64a1.998 1.998 0 0 0 2.83 0l1.25-1.25a.751.751 0 0 1 1.042.018.751.751 0 0 1 .018 1.042l-1.25 1.25a3.5 3.5 0 1 1-4.95-4.95l2.5-2.5a3.5 3.5 0 0 1 4.95 0 .751.751 0 0 1-.018 1.042.751.751 0 0 1-1.042.018 1.998 1.998 0 0 0-2.83 0l-2.5 2.5a1.998 1.998 0 0 0 0 2.83Z"></path></svg></button></div>
            <hr role="presentation" aria-hidden="true" class="ActionBar-item ActionBar-divider">
            <div data-targets="action-bar.items" data-view-component="true" class="ActionBar-item" style="visibility: visible;"><button id="action-bar-80e9f7f3-b064-441c-8e08-52dcb661ce62" data-md-button="ordered-list" type="button" class="Button Button--iconOnly Button--invisible Button--medium"> <svg aria-hidden="true" height="16" viewBox="0 0 16 16" version="1.1" width="16" data-view-component="true" class="octicon octicon-list-ordered Button-visual"><path d="M5 3.25a.75.75 0 0 1 .75-.75h8.5a.75.75 0 0 1 0 1.5h-8.5A.75.75 0 0 1 5 3.25Zm0 5a.75.75 0 0 1 .75-.75h8.5a.75.75 0 0 1 0 1.5h-8.5A.75.75 0 0 1 5 8.25Zm0 5a.75.75 0 0 1 .75-.75h8.5a.75.75 0 0 1 0 1.5h-8.5a.75.75 0 0 1-.75-.75ZM.924 10.32a.5.5 0 0 1-.851-.525l.001-.001.001-.002.002-.004.007-.011c.097-.144.215-.273.348-.384.228-.19.588-.392 1.068-.392.468 0 .858.181 1.126.484.259.294.377.673.377 1.038 0 .987-.686 1.495-1.156 1.845l-.047.035c-.303.225-.522.4-.654.597h1.357a.5.5 0 0 1 0 1H.5a.5.5 0 0 1-.5-.5c0-1.005.692-1.52 1.167-1.875l.035-.025c.531-.396.8-.625.8-1.078a.57.57 0 0 0-.128-.376C1.806 10.068 1.695 10 1.5 10a.658.658 0 0 0-.429.163.835.835 0 0 0-.144.153ZM2.003 2.5V6h.503a.5.5 0 0 1 0 1H.5a.5.5 0 0 1 0-1h.503V3.308l-.28.14a.5.5 0 0 1-.446-.895l1.003-.5a.5.5 0 0 1 .723.447Z"></path></svg></button></div>
            <div data-targets="action-bar.items" data-view-component="true" class="ActionBar-item" style="visibility: visible;"><button id="action-bar-4c034cca-38b9-4cb5-a27e-cc9425de5da1" data-md-button="unordered-list" type="button" class="Button Button--iconOnly Button--invisible Button--medium"> <svg aria-hidden="true" height="16" viewBox="0 0 16 16" version="1.1" width="16" data-view-component="true" class="octicon octicon-list-unordered Button-visual"><path d="M5.75 2.5h8.5a.75.75 0 0 1 0 1.5h-8.5a.75.75 0 0 1 0-1.5Zm0 5h8.5a.75.75 0 0 1 0 1.5h-8.5a.75.75 0 0 1 0-1.5Zm0 5h8.5a.75.75 0 0 1 0 1.5h-8.5a.75.75 0 0 1 0-1.5ZM2 14a1 1 0 1 1 0-2 1 1 0 0 1 0 2Zm1-6a1 1 0 1 1-2 0 1 1 0 0 1 2 0ZM2 4a1 1 0 1 1 0-2 1 1 0 0 1 0 2Z"></path></svg></button></div>
            <div data-targets="action-bar.items" data-view-component="true" class="ActionBar-item" style="visibility: visible;"><button id="action-bar-67306f83-c9d7-4b05-b059-e01f07be4318" data-md-button="task-list" type="button" class="Button Button--iconOnly Button--invisible Button--medium"> <svg aria-hidden="true" height="16" viewBox="0 0 16 16" version="1.1" width="16" data-view-component="true" class="octicon octicon-tasklist Button-visual"><path d="M2 2h4a1 1 0 0 1 1 1v4a1 1 0 0 1-1 1H2a1 1 0 0 1-1-1V3a1 1 0 0 1 1-1Zm4.655 8.595a.75.75 0 0 1 0 1.06L4.03 14.28a.75.75 0 0 1-1.06 0l-1.5-1.5a.749.749 0 0 1 .326-1.275.749.749 0 0 1 .734.215l.97.97 2.095-2.095a.75.75 0 0 1 1.06 0ZM9.75 2.5h5.5a.75.75 0 0 1 0 1.5h-5.5a.75.75 0 0 1 0-1.5Zm0 5h5.5a.75.75 0 0 1 0 1.5h-5.5a.75.75 0 0 1 0-1.5Zm0 5h5.5a.75.75 0 0 1 0 1.5h-5.5a.75.75 0 0 1 0-1.5Zm-7.25-9v3h3v-3Z"></path></svg></button></div>
        </div>
        <textarea class="form-control" id="editor" rows="10"></textarea>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const editor = document.getElementById('editor');
    const toolbar = document.querySelector('.ActionBar-item-container');

    const formatters = {
        'bold': { type: 'inline', markdown: '**' },
        'italic': { type: 'inline', markdown: '*' },
        'code': { type: 'inline', markdown: '`' },
        'header-3': { type: 'line', markdown: '### ' },
        'quote': { type: 'line', markdown: '> ' },
        'unordered-list': { type: 'line', markdown: '- ' },
    };

    toolbar.addEventListener('click', function(e) {
        const button = e.target.closest('button');
        if (!button) return;

        const mdButton = button.dataset.mdButton;
        const formatter = formatters[mdButton];

        if (formatter) {
            if (formatter.type === 'inline') {
                toggleInlineStyle(formatter.markdown);
            } else if (formatter.type === 'line') {
                toggleLineStyle(formatter.markdown);
            }
        } else if (mdButton === 'link') {
            insertLink();
        } else if (mdButton === 'ordered-list') {
            toggleOrderedList();
        }
    });

    function toggleInlineStyle(markdown) {
        const start = editor.selectionStart;
        const end = editor.selectionEnd;
        const selectedText = editor.value.substring(start, end);
        const wrap = markdown;

        const textBefore = editor.value.substring(start - wrap.length, start);
        const textAfter = editor.value.substring(end, end + wrap.length);

        if (textBefore === wrap && textAfter === wrap) {
            // Unwrap
            editor.setRangeText(selectedText, start - wrap.length, end + wrap.length, 'select');
        } else {
            // Wrap
            editor.setRangeText(wrap + selectedText + wrap, start, end, 'select');
        }
        editor.focus();
    }

    function toggleLineStyle(markdown) {
        const start = editor.selectionStart;
        const end = editor.selectionEnd;
        // Find the start and end of the line(s)
        let lineStart = editor.value.lastIndexOf('\n', start - 1) + 1;
        let lineEnd = editor.value.indexOf('\n', end);
        if (lineEnd === -1) lineEnd = editor.value.length;

        const selectedLines = editor.value.substring(lineStart, lineEnd);
        const lines = selectedLines.split('\n');

        const allLinesHaveMarkdown = lines.every(line => line.startsWith(markdown));

        let newLines;
        if (allLinesHaveMarkdown) {
            // Remove markdown
            newLines = lines.map(line => line.substring(markdown.length));
        } else {
            // Add markdown
            newLines = lines.map(line => markdown + line);
        }

        editor.setRangeText(newLines.join('\n'), lineStart, lineEnd, 'select');
        editor.focus();
    }

    function toggleOrderedList() {
        const start = editor.selectionStart;
        const end = editor.selectionEnd;
        let lineStart = editor.value.lastIndexOf('\n', start - 1) + 1;
        let lineEnd = editor.value.indexOf('\n', end);
        if (lineEnd === -1) lineEnd = editor.value.length;

        const selectedLines = editor.value.substring(lineStart, lineEnd);
        const lines = selectedLines.split('\n');

        const isOrderedList = /^\d+\.\s/.test(lines[0]);

        let newLines;
        if (isOrderedList) {
            // Remove numbering
            newLines = lines.map(line => line.replace(/^\d+\.\s/, ''));
        } else {
            // Add numbering
            newLines = lines.map((line, i) => `${i + 1}. ${line}`);
        }

        editor.setRangeText(newLines.join('\n'), lineStart, lineEnd, 'select');
        editor.focus();
    }

    function insertLink() {
        const start = editor.selectionStart;
        const end = editor.selectionEnd;
        const selectedText = editor.value.substring(start, end);
        const url = prompt('Enter a URL:');
        if (url) {
            editor.setRangeText(`[${selectedText}](${url})`, start, end, 'select');
        }
        editor.focus();
    }
});
</script>

</body>
</html>
