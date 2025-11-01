<?php
include 'editor_header.php';
?>

<div class="container mt-5">
    <h2 class="mb-4">WYSIWYG Editor</h2>
    <div id="editor-container">
        <div data-target="action-bar.itemContainer" data-view-component="true" class="ActionBar-item-container">
            <div data-targets="action-bar.items" data-view-component="true" class="ActionBar-item" style="visibility: visible;"><button id="action-bar-5bbf6d0e-3532-4b04-8aab-1a845f1e4d28" data-md-button="header-3" data-analytics-event="{&quot;category&quot;:&quot;comment_box&quot;,&quot;action&quot;:&quot;HEADING&quot;,&quot;label&quot;:null}" aria-labelledby="tooltip-67082bd1-0f47-40e6-a6e7-e632edb9dbf4" type="button" data-view-component="true" class="Button Button--iconOnly Button--invisible Button--medium" tabindex="0">  <svg aria-hidden="true" height="16" viewBox="0 0 16 16" version="1.1" width="16" data-view-component="true" class="octicon octicon-heading Button-visual">
          <path d="M3.75 2a.75.75 0 0 1 .75.75V7h7V2.75a.75.75 0 0 1 1.5 0v10.5a.75.75 0 0 1-1.5 0V8.5h-7v4.75a.75.75 0 0 1-1.5 0V2.75A.75.75 0 0 1 3.75 2Z"></path>
      </svg>
      </button><tool-tip id="tooltip-67082bd1-0f47-40e6-a6e7-e632edb9dbf4" for="action-bar-5bbf6d0e-3532-4b04-8aab-1a845f1e4d28" popover="manual" data-direction="s" data-type="label" data-view-component="true" class="position-absolute sr-only" aria-hidden="true" role="tooltip" style="--tool-tip-position-top: 734.4875183105469px; --tool-tip-position-left: 547.6312503814697px;">Heading</tool-tip>
      </div>
            <div data-targets="action-bar.items" data-view-component="true" class="ActionBar-item" style="visibility: visible;"><button id="action-bar-91e22fef-551e-4cb9-b99d-641aec4546d4" data-md-button="bold" data-hotkey-scope="new_comment_field" data-hotkey="Control+b" data-analytics-event="{&quot;category&quot;:&quot;comment_box&quot;,&quot;action&quot;:&quot;BOLD&quot;,&quot;label&quot;:null}" aria-labelledby="tooltip-78d8fc04-b819-4f3c-b6f7-cdd3e0512aeb" type="button" data-view-component="true" class="Button Button--iconOnly Button--invisible Button--medium" tabindex="-1">  <svg aria-hidden="true" height="16" viewBox="0 0 16 16" version="1.1" width="16" data-view-component="true" class="octicon octicon-bold Button-visual">
          <path d="M4 2h4.5a3.501 3.501 0 0 1 2.852 5.53A3.499 3.499 0 0 1 9.5 14H4a1 1 0 0 1-1-1V3a1 1 0 0 1 1-1Zm1 7v3h4.5a1.5 1.5 0 0 0 0-3Zm3.5-2a1.5 1.5 0 0 0 0-3H5v3Z"></path>
      </svg>
      </button><tool-tip id="tooltip-78d8fc04-b819-4f3c-b6f7-cdd3e0512aeb" for="action-bar-91e22fef-551e-4cb9-b99d-641aec4546d4" popover="manual" data-direction="s" data-type="label" data-view-component="true" class="sr-only position-absolute" aria-hidden="true" role="tooltip">Bold</tool-tip>
      </div>
            <div data-targets="action-bar.items" data-view-component="true" class="ActionBar-item" style="visibility: visible;"><button id="action-bar-3bfeac06-1017-4177-a9ff-5f5594b5a99f" data-md-button="italic" data-hotkey-scope="new_comment_field" data-hotkey="Control+i" data-analytics-event="{&quot;category&quot;:&quot;comment_box&quot;,&quot;action&quot;:&quot;ITALIC&quot;,&quot;label&quot;:null}" aria-labelledby="tooltip-8919c9fa-4fc5-474e-9eda-20dfa16e206f" type="button" data-view-component="true" class="Button Button--iconOnly Button--invisible Button--medium" tabindex="-1">  <svg aria-hidden="true" height="16" viewBox="0 0 16 16" version="1.1" width="16" data-view-component="true" class="octicon octicon-italic Button-visual">
          <path d="M6 2.75A.75.75 0 0 1 6.75 2h6.5a.75.75 0 0 1 0 1.5h-2.505l-3.858 9H9.25a.75.75 0 0 1 0 1.5h-6.5a.75.75 0 0 1 0-1.5h2.505l3.858-9H6.75A.75.75 0 0 1 6 2.75Z"></path>
      </svg>
      </button><tool-tip id="tooltip-8919c9fa-4fc5-474e-9eda-20dfa16e206f" for="action-bar-3bfeac06-1017-4177-a9ff-5f5594b5a99f" popover="manual" data-direction="s" data-type="label" data-view-component="true" class="sr-only position-absolute" aria-hidden="true" role="tooltip">Italic</tool-tip>
      </div>
            <div data-targets="action-bar.items" data-view-component="true" class="ActionBar-item" style="visibility: visible;"><button id="action-bar-edbbd220-dda5-40cd-a0c2-9eff982bdc17" data-md-button="quote" data-hotkey-scope="new_comment_field" data-hotkey="Control+Shift+&gt;" data-analytics-event="{&quot;category&quot;:&quot;comment_box&quot;,&quot;action&quot;:&quot;QUOTE&quot;,&quot;label&quot;:null}" aria-labelledby="tooltip-9f1fa9f3-4750-4188-8710-2d4b117a2bf4" type="button" data-view-component="true" class="Button Button--iconOnly Button--invisible Button--medium" tabindex="-1">  <svg aria-hidden="true" height="16" viewBox="0 0 16 16" version="1.1" width="16" data-view-component="true" class="octicon octicon-quote Button-visual">
          <path d="M1.75 2.5h10.5a.75.75 0 0 1 0 1.5H1.75a.75.75 0 0 1 0-1.5Zm4 5h8.5a.75.75 0 0 1 0 1.5h-8.5a.75.75 0 0 1 0-1.5Zm0 5h8.5a.75.75 0 0 1 0 1.5h-8.5a.75.75 0 0 1 0-1.5ZM2.5 7.75v6a.75.75 0 0 1-1.5 0v-6a.75.75 0 0 1 1.5 0Z"></path>
      </svg>
      </button><tool-tip id="tooltip-9f1fa9f3-4750-4188-8710-2d4b117a2bf4" for="action-bar-edbbd220-dda5-40cd-a0c2-9eff982bdc17" popover="manual" data-direction="s" data-type="label" data-view-component="true" class="sr-only position-absolute" aria-hidden="true" role="tooltip">Quote</tool-tip>
      </div>
            <div data-targets="action-bar.items" data-view-component="true" class="ActionBar-item" style="visibility: visible;"><button id="action-bar-f9bf4781-2ca6-4137-9247-8904db1afdc0" data-md-button="code" data-hotkey-scope="new_comment_field" data-hotkey="Control+e" data-analytics-event="{&quot;category&quot;:&quot;comment_box&quot;,&quot;action&quot;:&quot;CODE&quot;,&quot;label&quot;:null}" aria-labelledby="tooltip-1046c4b9-66f9-45d6-a452-d7d6a45a8a03" type="button" data-view-component="true" class="Button Button--iconOnly Button--invisible Button--medium" tabindex="-1">  <svg aria-hidden="true" height="16" viewBox="0 0 16 16" version="1.1" width="16" data-view-component="true" class="octicon octicon-code Button-visual">
          <path d="m11.28 3.22 4.25 4.25a.75.75 0 0 1 0 1.06l-4.25 4.25a.749.749 0 0 1-1.275-.326.749.749 0 0 1 .215-.734L13.94 8l-3.72-3.72a.749.749 0 0 1 .326-1.275.749.749 0 0 1 .734.215Zm-6.56 0a.751.751 0 0 1 1.042.018.751.751 0 0 1 .018 1.042L2.06 8l3.72 3.72a.749.749 0 0 1-.326 1.275.749.749 0 0 1-.734-.215L.47 8.53a.75.75 0 0 1 0-1.06Z"></path>
      </svg>
      </button><tool-tip id="tooltip-1046c4b9-66f9-45d6-a452-d7d6a45a8a03" for="action-bar-f9bf4781-2ca6-4137-9247-8904db1afdc0" popover="manual" data-direction="s" data-type="label" data-view-component="true" class="sr-only position-absolute" aria-hidden="true" role="tooltip">Code</tool-tip>
      </div>
            <div data-targets="action-bar.items" data-view-component="true" class="ActionBar-item" style="visibility: visible;"><button id="action-bar-98f6ddf1-0a6c-4120-b13b-35ca1f8e2191" data-md-button="link" data-hotkey-scope="new_comment_field" data-hotkey="Control+k" data-analytics-event="{&quot;category&quot;:&quot;comment_box&quot;,&quot;action&quot;:&quot;LINK&quot;,&quot;label&quot;:null}" aria-labelledby="tooltip-0160979a-f857-4e21-bea5-28db81a7c791" type="button" data-view-component="true" class="Button Button--iconOnly Button--invisible Button--medium" tabindex="-1">  <svg aria-hidden="true" height="16" viewBox="0 0 16 16" version="1.1" width="16" data-view-component="true" class="octicon octicon-link Button-visual">
          <path d="m7.775 3.275 1.25-1.25a3.5 3.5 0 1 1 4.95 4.95l-2.5 2.5a3.5 3.5 0 0 1-4.95 0 .751.751 0 0 1 .018-1.042.751.751 0 0 1 1.042-.018 1.998 1.998 0 0 0 2.83 0l2.5-2.5a2.002 2.002 0 0 0-2.83-2.83l-1.25 1.25a.751.751 0 0 1-1.042-.018.751.751 0 0 1-.018-1.042Zm-4.69 9.64a1.998 1.998 0 0 0 2.83 0l1.25-1.25a.751.751 0 0 1 1.042.018.751.751 0 0 1 .018 1.042l-1.25 1.25a3.5 3.5 0 1 1-4.95-4.95l2.5-2.5a3.5 3.5 0 0 1 4.95 0 .751.751 0 0 1-.018 1.042.751.751 0 0 1-1.042.018 1.998 1.998 0 0 0-2.83 0l-2.5 2.5a1.998 1.998 0 0 0 0 2.83Z"></path>
      </svg>
      </button><tool-tip id="tooltip-0160979a-f857-4e21-bea5-28db81a7c791" for="action-bar-98f6ddf1-0a6c-4120-b13b-35ca1f8e2191" popover="manual" data-direction="s" data-type="label" data-view-component="true" class="sr-only position-absolute" aria-hidden="true" role="tooltip">Link</tool-tip>
      </div>
            <hr role="presentation" aria-hidden="true" data-targets="action-bar.items" data-view-component="true" class="ActionBar-item ActionBar-divider" style="visibility: visible;">
            <div data-targets="action-bar.items" data-view-component="true" class="ActionBar-item" style="visibility: visible;"><button id="action-bar-80e9f7f3-b064-441c-8e08-52dcb661ce62" data-md-button="ordered-list" data-hotkey-scope="new_comment_field" data-hotkey="Control+Shift+&amp;" data-analytics-event="{&quot;category&quot;:&quot;comment_box&quot;,&quot;action&quot;:&quot;ORDERED_LIST&quot;,&quot;label&quot;:null}" aria-labelledby="tooltip-91304c07-f47f-46a0-847d-37728b5cb52c" type="button" data-view-component="true" class="Button Button--iconOnly Button--invisible Button--medium" tabindex="-1">  <svg aria-hidden="true" height="16" viewBox="0 0 16 16" version="1.1" width="16" data-view-component="true" class="octicon octicon-list-ordered Button-visual">
          <path d="M5 3.25a.75.75 0 0 1 .75-.75h8.5a.75.75 0 0 1 0 1.5h-8.5A.75.75 0 0 1 5 3.25Zm0 5a.75.75 0 0 1 .75-.75h8.5a.75.75 0 0 1 0 1.5h-8.5A.75.75 0 0 1 5 8.25Zm0 5a.75.75 0 0 1 .75-.75h8.5a.75.75 0 0 1 0 1.5h-8.5a.75.75 0 0 1-.75-.75ZM.924 10.32a.5.5 0 0 1-.851-.525l.001-.001.001-.002.002-.004.007-.011c.097-.144.215-.273.348-.384.228-.19.588-.392 1.068-.392.468 0 .858.181 1.126.484.259.294.377.673.377 1.038 0 .987-.686 1.495-1.156 1.845l-.047.035c-.303.225-.522.4-.654.597h1.357a.5.5 0 0 1 0 1H.5a.5.5 0 0 1-.5-.5c0-1.005.692-1.52 1.167-1.875l.035-.025c.531-.396.8-.625.8-1.078a.57.57 0 0 0-.128-.376C1.806 10.068 1.695 10 1.5 10a.658.658 0 0 0-.429.163.835.835 0 0 0-.144.153ZM2.003 2.5V6h.503a.5.5 0 0 1 0 1H.5a.5.5 0 0 1 0-1h.503V3.308l-.28.14a.5.5 0 0 1-.446-.895l1.003-.5a.5.5 0 0 1 .723.447Z"></path>
      </svg>
      </button><tool-tip id="tooltip-91304c07-f47f-46a0-847d-37728b5cb52c" for="action-bar-80e9f7f3-b064-441c-8e08-52dcb661ce62" popover="manual" data-direction="s" data-type="label" data-view-component="true" class="sr-only position-absolute" aria-hidden="true" role="tooltip">Numbered list</tool-tip>
      </div>
            <div data-targets="action-bar.items" data-view-component="true" class="ActionBar-item" style="visibility: visible;"><button id="action-bar-4c034cca-38b9-4cb5-a27e-cc9425de5da1" data-md-button="unordered-list" data-hotkey-scope="new_comment_field" data-hotkey="Control+Shift+*" data-analytics-event="{&quot;category&quot;:&quot;comment_box&quot;,&quot;action&quot;:&quot;UNORDERED_LIST&quot;,&quot;label&quot;:null}" aria-labelledby="tooltip-f06146de-498d-4779-957c-fae5e80e2325" type="button" data-view-component="true" class="Button Button--iconOnly Button--invisible Button--medium" tabindex="-1">  <svg aria-hidden="true" height="16" viewBox="0 0 16 16" version="1.1" width="16" data-view-component="true" class="octicon octicon-list-unordered Button-visual">
          <path d="M5.75 2.5h8.5a.75.75 0 0 1 0 1.5h-8.5a.75.75 0 0 1 0-1.5Zm0 5h8.5a.75.75 0 0 1 0 1.5h-8.5a.75.75 0 0 1 0-1.5Zm0 5h8.5a.75.75 0 0 1 0 1.5h-8.5a.75.75 0 0 1 0-1.5ZM2 14a1 1 0 1 1 0-2 1 1 0 0 1 0 2Zm1-6a1 1 0 1 1-2 0 1 1 0 0 1 2 0ZM2 4a1 1 0 1 1 0-2 1 1 0 0 1 0 2Z"></path>
      </svg>
      </button><tool-tip id="tooltip-f06146de-498d-4779-957c-fae5e80e2325" for="action-bar-4c034cca-38b9-4cb5-a27e-cc9425de5da1" popover="manual" data-direction="s" data-type="label" data-view-component="true" class="sr-only position-absolute" aria-hidden="true" role="tooltip">Unordered list</tool-tip>
      </div>
            <div data-targets="action-bar.items" data-view-component="true" class="ActionBar-item" style="visibility: visible;"><button id="action-bar-67306f83-c9d7-4b05-b059-e01f07be4318" data-md-button="task-list" data-hotkey-scope="new_comment_field" data-hotkey="Control+Shift+L" data-analytics-event="{&quot;category&quot;:&quot;comment_box&quot;,&quot;action&quot;:&quot;TASK_LIST&quot;,&quot;label&quot;:null}" aria-labelledby="tooltip-c0370c51-fe21-429c-93cb-0c2536067b52" type="button" data-view-component="true" class="Button Button--iconOnly Button--invisible Button--medium" tabindex="-1">  <svg aria-hidden="true" height="16" viewBox="0 0 16 16" version="1.1" width="16" data-view-component="true" class="octicon octicon-tasklist Button-visual">
          <path d="M2 2h4a1 1 0 0 1 1 1v4a1 1 0 0 1-1 1H2a1 1 0 0 1-1-1V3a1 1 0 0 1 1-1Zm4.655 8.595a.75.75 0 0 1 0 1.06L4.03 14.28a.75.75 0 0 1-1.06 0l-1.5-1.5a.749.749 0 0 1 .326-1.275.749.749 0 0 1 .734.215l.97.97 2.095-2.095a.75.75 0 0 1 1.06 0ZM9.75 2.5h5.5a.75.75 0 0 1 0 1.5h-5.5a.75.75 0 0 1 0-1.5Zm0 5h5.5a.75.75 0 0 1 0 1.5h-5.5a.75.75 0 0 1 0-1.5Zm0 5h5.5a.75.75 0 0 1 0 1.5h-5.5a.75.75 0 0 1 0-1.5Zm-7.25-9v3h3v-3Z"></path>
      </svg>
      </button><tool-tip id="tooltip-c0370c51-fe21-429c-93cb-0c2536067b52" for="action-bar-67306f83-c9d7-4b05-b059-e01f07be4318" popover="manual" data-direction="s" data-type="label" data-view-component="true" class="sr-only position-absolute" aria-hidden="true" role="tooltip">Task list</tool-tip>
      </div>
            <hr role="presentation" aria-hidden="true" data-targets="action-bar.items" data-view-component="true" class="ActionBar-item ActionBar-divider" style="visibility: visible;">
            <div data-targets="action-bar.items" data-view-component="true" class="ActionBar-item" style="visibility: visible;"><button id="action-bar-216a3f41-9756-4ed2-9c36-91c5a0c4abe0" data-analytics-event="{&quot;category&quot;:&quot;comment_box&quot;,&quot;action&quot;:&quot;ATTACH_FILES&quot;,&quot;label&quot;:null}" data-file-attachment-for="fc-new_comment_field" aria-labelledby="tooltip-aa851478-084f-4164-997f-4c009a82e801" type="button" data-view-component="true" class="Button Button--iconOnly Button--invisible Button--medium" tabindex="-1">  <svg aria-hidden="true" height="16" viewBox="0 0 16 16" version="1.1" width="16" data-view-component="true" class="octicon octicon-paperclip Button-visual">
          <path d="M12.212 3.02a1.753 1.753 0 0 0-2.478.003l-5.83 5.83a3.007 3.007 0 0 0-.88 2.127c0 .795.315 1.551.88 2.116.567.567 1.333.89 2.126.89.79 0 1.548-.321 2.116-.89l5.48-5.48a.75.75 0 0 1 1.061 1.06l-5.48 5.48a4.492 4.492 0 0 1-3.177 1.33c-1.2 0-2.345-.487-3.187-1.33a4.483 4.483 0 0 1-1.32-3.177c0-1.195.475-2.341 1.32-3.186l5.83-5.83a3.25 3.25 0 0 1 5.553 2.297c0 .863-.343 1.691-.953 2.301L7.439 12.39c-.375.377-.884.59-1.416.593a1.998 1.998 0 0 1-1.412-.593 1.992 1.992 0 0 1 0-2.828l5.48-5.48a.751.751 0 0 1 1.042.018.751.751 0 0 1 .018 1.042l-5.48 5.48a.492.492 0 0 0 0 .707.499.499 0 0 0 .352.154.51.51 0 0 0 .356-.154l5.833-5.827a1.755 1.755 0 0 0 0-2.481Z"></path>
      </svg>
      </button><tool-tip id="tooltip-aa851478-084f-4164-997f-4c009a82e801" for="action-bar-216a3f41-9756-4ed2-9c36-91c5a0c4abe0" popover="manual" data-direction="s" data-type="label" data-view-component="true" class="sr-only position-absolute" aria-hidden="true" role="tooltip">Attach files</tool-tip>
      </div>
            <div data-targets="action-bar.items" data-view-component="true" class="ActionBar-item" style="visibility: visible;"><button id="action-bar-1a2e1f12-af77-461f-a0fb-293bfaf40f98" data-md-button="mention" data-analytics-event="{&quot;category&quot;:&quot;comment_box&quot;,&quot;action&quot;:&quot;MENTION&quot;,&quot;label&quot;:null}" aria-labelledby="tooltip-3d2f8f0b-bf9b-4c35-ad06-f1b56460f9a5" type="button" data-view-component="true" class="Button Button--iconOnly Button--invisible Button--medium" tabindex="-1">  <svg aria-hidden="true" height="16" viewBox="0 0 16 16" version="1.1" width="16" data-view-component="true" class="octicon octicon-mention Button-visual">
          <path d="M8 .5a7.499 7.499 0 0 1 7.499 7.462l.002.038v1.164a2.612 2.612 0 0 1-4.783 1.454A3.763 3.763 0 0 1 8 11.776 3.776 3.776 0 1 1 11.776 8v1.164a1.112 1.112 0 0 0 2.225 0L14 8a6 6 0 1 0-3.311 5.365.75.75 0 0 1 .673 1.341A7.5 7.5 0 1 1 8 .5Zm0 5.225a2.275 2.275 0 1 0 0 4.552 2.275 2.275 0 0 0 0-4.552Z"></path>
      </svg>
      </button><tool-tip id="tooltip-3d2f8f0b-bf9b-4c35-ad06-f1b56460f9a5" for="action-bar-1a2e1f12-af77-461f-a0fb-293bfaf40f98" popover="manual" data-direction="s" data-type="label" data-view-component="true" class="sr-only position-absolute" aria-hidden="true" role="tooltip">Mention</tool-tip>
      </div>
            <div data-targets="action-bar.items" data-view-component="true" class="ActionBar-item" style="visibility: visible;"><button id="action-bar-c868bd5e-48fb-4625-a434-c2319e5d8ff9" data-md-button="ref" data-analytics-event="{&quot;category&quot;:&quot;comment_box&quot;,&quot;action&quot;:&quot;REFERENCE&quot;,&quot;label&quot;:null}" aria-labelledby="tooltip-f9a28b84-95e7-4100-8a86-ac5d9a24e4d4" type="button" data-view-component="true" class="Button Button--iconOnly Button--invisible Button--medium" tabindex="-1">  <svg aria-hidden="true" height="16" viewBox="0 0 16 16" version="1.1" width="16" data-view-component="true" class="octicon octicon-cross-reference Button-visual">
          <path d="M2.75 3.5a.25.25 0 0 0-.25.25v7.5c0 .138.112.25.25.25h2a.75.75 0 0 1 .75.75v2.19l2.72-2.72a.749.749 0 0 1 .53-.22h4.5a.25.25 0 0 0 .25-.25v-2.5a.75.75 0 0 1 1.5 0v2.5A1.75 1.75 0 0 1 13.25 13H9.06l-2.573 2.573A1.458 1.458 0 0 1 4 14.543V13H2.75A1.75 1.75 0 0 1 1 11.25v-7.5C1 2.784 1.784 2 2.75 2h5.5a.75.75 0 0 1 0 1.5ZM16 1.25v4.146a.25.25 0 0 1-.427.177L14.03 4.03l-3.75 3.75a.749.749 0 0 1-1.275-.326.749.749 0 0 1 .215-.734l3.75-3.75-1.543-1.543A.25.25 0 0 1 11.604 1h4.146a.25.25 0 0 1 .25.25Z"></path>
      </svg>
      </button><tool-tip id="tooltip-f9a28b84-95e7-4100-8a86-ac5d9a24e4d4" for="action-bar-c868bd5e-48fb-4625-a434-c2319e5d8ff9" popover="manual" data-direction="s" data-type="label" data-view-component="true" class="sr-only position-absolute" aria-hidden="true" role="tooltip">Reference</tool-tip>
      </div>
            <div data-targets="action-bar.items" data-view-component="true" class="ActionBar-item" style="visibility: visible;"><button id="action-bar-db14557c-bbd9-4357-bccd-996c9a1551d3" data-show-dialog-id="saved_replies_menu_new_comment_field-dialog" data-analytics-event="{&quot;category&quot;:&quot;comment_box&quot;,&quot;action&quot;:&quot;SAVED_REPLIES&quot;,&quot;label&quot;:null}" aria-labelledby="tooltip-d25537c4-ca31-4639-a1f5-56a2d0f8c378" type="button" data-view-component="true" class="Button Button--iconOnly Button--invisible Button--medium" tabindex="-1">  <svg aria-hidden="true" height="16" viewBox="0 0 16 16" version="1.1" width="16" data-view-component="true" class="octicon octicon-reply Button-visual">
          <path d="M6.78 1.97a.75.75 0 0 1 0 1.06L3.81 6h6.44A4.75 4.75 0 0 1 15 10.75v2.5a.75.75 0 0 1-1.5 0v-2.5a3.25 3.25 0 0 0-3.25-3.25H3.81l2.97 2.97a.749.749 0 0 1-.326 1.275.749.749 0 0 1-.734-.215L1.47 7.28a.75.75 0 0 1 0-1.06l4.25-4.25a.75.75 0 0 1 1.06 0Z"></path>
      </svg>
      </button><tool-tip id="tooltip-d25537c4-ca31-4639-a1f5-56a2d0f8c378" for="action-bar-db14557c-bbd9-4357-bccd-996c9a1551d3" popover="manual" data-direction="s" data-type="label" data-view-component="true" class="sr-only position-absolute" aria-hidden="true" role="tooltip">Saved replies</tool-tip>
      </div>
            <slash-command-toolbar-button data-targets="action-bar.items" data-view-component="true" class="ActionBar-item" data-catalyst="" data-command="" style="visibility: visible;"><button id="action-bar-92a22b6a-0034-4ea2-9b4d-0f21eb27b421" data-action="click:slash-command-toolbar-button#triggerMenu" data-analytics-event="{&quot;category&quot;:&quot;comment_box&quot;,&quot;action&quot;:&quot;SLASH_COMMANDS&quot;,&quot;label&quot;:null}" aria-labelledby="tooltip-9278b652-d555-4e23-93c5-5e027fb7c830" type="button" data-view-component="true" class="Button Button--iconOnly Button--invisible Button--medium" tabindex="-1">  <svg aria-hidden="true" height="16" viewBox="0 0 16 16" version="1.1" width="16" data-view-component="true" class="octicon octicon-diff-ignored Button-visual">
          <path d="M13.25 1c.966 0 1.75.784 1.75 1.75v10.5A1.75 1.75 0 0 1 13.25 15H2.75A1.75 1.75 0 0 1 1 13.25V2.75C1 1.784 1.784 1 2.75 1ZM2.75 2.5a.25.25 0 0 0-.25.25v10.5c0 .138.112.25.25.25h10.5a.25.25 0 0 0 .25-.25V2.75a.25.25 0 0 0-.25-.25Zm8.53 3.28-5.5 5.5a.749.749 0 0 1-1.275-.326.749.749 0 0 1 .215-.734l5.5-5.5a.751.751 0 0 1 1.042.018.751.751 0 0 1 .018 1.042Z"></path>
      </svg>
      </button><tool-tip id="tooltip-9278b652-d555-4e23-93c5-5e027fb7c830" for="action-bar-92a22b6a-0034-4ea2-9b4d-0f21eb27b421" popover="manual" data-direction="s" data-type="label" data-view-component="true" class="sr-only position-absolute" aria-hidden="true" role="tooltip">Slash commands</tool-tip>
      </slash-command-toolbar-button>
      </div>
        <textarea class="form-control" id="editor" rows="10"></textarea>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const editor = document.getElementById('editor');
    const toolbar = document.querySelector('.ActionBar-item-container');

    toolbar.addEventListener('click', function(e) {
        const button = e.target.closest('button');
        if (!button) return;

        const mdButton = button.dataset.mdButton;
        const selectionStart = editor.selectionStart;
        const selectionEnd = editor.selectionEnd;
        const selectedText = editor.value.substring(selectionStart, selectionEnd);

        let newText;

        switch (mdButton) {
            case 'header-3':
                newText = `### ${selectedText}`;
                break;
            case 'bold':
                newText = `**${selectedText}**`;
                break;
            case 'italic':
                newText = `*${selectedText}*`;
                break;
            case 'quote':
                newText = `> ${selectedText}`;
                break;
            case 'code':
                newText = `\`${selectedText}\``;
                break;
            case 'link':
                const url = prompt('Enter a URL:');
                if (url) {
                    newText = `[${selectedText}](${url})`;
                } else {
                    newText = selectedText;
                }
                break;
            case 'ordered-list':
                newText = selectedText.split('\n').map((line, i) => `${i + 1}. ${line}`).join('\n');
                break;
            case 'unordered-list':
                newText = selectedText.split('\n').map(line => `- ${line}`).join('\n');
                break;
            case 'task-list':
                newText = selectedText.split('\n').map(line => `- [ ] ${line}`).join('\n');
                break;
            default:
                newText = selectedText;
        }

        editor.setRangeText(newText, selectionStart, selectionEnd, 'select');
        editor.focus();
    });
});
</script>

</body>
</html>
