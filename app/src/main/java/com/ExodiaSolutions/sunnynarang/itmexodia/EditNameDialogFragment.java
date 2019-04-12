package com.ExodiaSolutions.sunnynarang.itmexodia;

import android.app.Dialog;
import android.os.Bundle;
import android.support.annotation.Nullable;
import android.support.v4.app.DialogFragment;
import android.text.Html;
import android.view.KeyEvent;
import android.view.LayoutInflater;
import android.view.View;
import android.view.ViewGroup;
import android.view.Window;
import android.view.inputmethod.EditorInfo;
import android.widget.EditText;
import android.widget.TextView;

import java.sql.Date;

/**
 * Created by Sunny Narang on 05-09-2016.
 */
public class EditNameDialogFragment extends DialogFragment implements TextView.OnEditorActionListener {

    private EditText mEditText;

    public EditNameDialogFragment() {
        // Empty constructor is required for DialogFragment
        // Make sure not to add arguments to the constructor
        // Use `newInstance` instead as shown below
    }

    @Override
    public Dialog onCreateDialog(Bundle savedInstanceState) {
        Dialog dialog = super.onCreateDialog(savedInstanceState);
        // request a window without the title
       /* int width = getResources().getDimensionPixelSize(R.dimen.popup_width);
        int height = getResources().getDimensionPixelSize(R.dimen.popup_height);
        getDialog().getWindow().setLayout(width, height);
        */dialog.getWindow().requestFeature(Window.FEATURE_NO_TITLE);
        return dialog;
    }
    public static EditNameDialogFragment newInstance(String title,String Body,String tec_name,String date) {
        EditNameDialogFragment frag = new EditNameDialogFragment();
        Bundle args = new Bundle();
        args.putString("title", title);
        args.putString("body", Body);
        args.putString("tec_name", tec_name);
        args.putString("date", date);
        frag.setArguments(args);
        return frag;
    }

    public interface EditNameDialogListener {
        void onFinishEditDialog(String inputText);
    }
    @Override
    public View onCreateView(LayoutInflater inflater, ViewGroup container,
                             Bundle savedInstanceState) {
        return inflater.inflate(R.layout.notice_fragment_dialog, container);
    }

    @Override
    public void onViewCreated(View view, @Nullable Bundle savedInstanceState) {
        super.onViewCreated(view, savedInstanceState);
        // Get field from view

        // Fetch arguments from bundle and set title
        String title = getArguments().getString("title", "NOTICE");
        String body = getArguments().getString("body", "NOTICE BODY");
        String tec_name = getArguments().getString("tec_name", "TEACHER NAME");
        String date = getArguments().getString("date", "Date");
        getDialog().setTitle(title);
        TextView fd_title = (TextView) view.findViewById(R.id.FD_title);
        TextView tv = (TextView) view.findViewById(R.id.FD_textview);
        TextView fd_date = (TextView) view.findViewById(R.id.FD_date);
        TextView fd_tec_name = (TextView) view.findViewById(R.id.FD_tec_name);

       /* Typeface custom_font1 = Typeface.createFromAsset(getAssets(), "fonts/Oswald-Regular.ttf");
        fd_title.setTypeface(custom_font1);

*/      if(date.contains(" ")) {
            String[] a = date.split(" ");
            date = a[0];
        }
        tv.setText(Html.fromHtml(body));
        fd_date.setText(Html.fromHtml(date));
        fd_tec_name.setText("- "+Html.fromHtml(tec_name));
        fd_title.setText(Html.fromHtml(title));
        // Show soft keyboard automatically and request focus to field
//        mEditText.requestFocus();
       // getDialog().getWindow().setSoftInputMode(
         //       WindowManager.LayoutParams.SOFT_INPUT_STATE_VISIBLE);
    }
    @Override
    public boolean onEditorAction(TextView textView, int actionId, KeyEvent keyEvent) {
        if (EditorInfo.IME_ACTION_DONE == actionId) {
            // Return input text back to activity through the implemented listener
            EditNameDialogListener listener = (EditNameDialogListener) getActivity();
            listener.onFinishEditDialog(mEditText.getText().toString());
            // Close the dialog and return back to the parent activity
            dismiss();
            return true;
        }
        return false;
    }


}