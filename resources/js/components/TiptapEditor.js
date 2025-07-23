import { Editor } from '@tiptap/core';
import { StarterKit } from '@tiptap/starter-kit';

export const initTiptapEditor = (editorId, initialContent = '') => {
    // Initialize the Tiptap editor
    const editor = new Editor({
        element: document.getElementById(editorId),
        extensions: [StarterKit],
        content: initialContent,
    });

    // Check if editor is initialized and log success
    console.log('Tiptap editor initialized:', editor);

    return editor;
};
