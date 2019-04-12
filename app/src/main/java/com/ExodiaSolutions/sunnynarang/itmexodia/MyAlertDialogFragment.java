package com.ExodiaSolutions.sunnynarang.itmexodia;

import android.app.Dialog;
import android.content.Context;
import android.net.ConnectivityManager;
import android.net.NetworkInfo;
import android.os.AsyncTask;
import android.os.Bundle;
import android.support.annotation.Nullable;
import android.support.v4.app.DialogFragment;
import android.view.LayoutInflater;
import android.view.View;
import android.view.ViewGroup;
import android.view.Window;
import android.view.WindowManager;
import android.widget.Button;
import android.widget.EditText;
import android.widget.ProgressBar;
import android.widget.Toast;

import java.io.BufferedReader;
import java.io.BufferedWriter;
import java.io.IOException;
import java.io.InputStream;
import java.io.InputStreamReader;
import java.io.OutputStream;
import java.io.OutputStreamWriter;
import java.net.HttpURLConnection;
import java.net.MalformedURLException;
import java.net.URL;
import java.net.URLEncoder;

/**
 * Created by Sunny Narang on 05-09-2016.
 */
public class MyAlertDialogFragment extends DialogFragment implements View.OnClickListener {

   String old_pwd_str,new_pwd_str,roll;
    EditText ed_old_pass,new_pwd,confirm_pwd;
    ProgressBar pb;

    public MyAlertDialogFragment() {
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
    public static MyAlertDialogFragment newInstance(String roll) {
        MyAlertDialogFragment frag = new MyAlertDialogFragment();
        Bundle args = new Bundle();
        args.putString("roll", roll);

        frag.setArguments(args);
        return frag;
    }

    @Override
    public void onClick(View view) {
       if(view.getId()==R.id.exit_btn){
           dismiss();
       }else if(view.getId()==R.id.confirm_btn){
           //Toast.makeText(getActivity(), ""+ed_old_pass.getText().toString()+new_pwd.getText().toString()+confirm_pwd.getText().toString(), Toast.LENGTH_SHORT).show();
           if(new_pwd.getText().toString().equalsIgnoreCase("")||ed_old_pass.getText().toString().equalsIgnoreCase("")||confirm_pwd.getText().toString().equalsIgnoreCase("")){
               Toast.makeText(getActivity(), "Invalid Details", Toast.LENGTH_SHORT).show();
           }
        else if(!new_pwd.getText().toString().equalsIgnoreCase(confirm_pwd.getText().toString())){
            Toast.makeText(getActivity(), "Both Password Doesn't Match", Toast.LENGTH_SHORT).show();
        } else if(new_pwd.getText().toString().length()<5){
            Toast.makeText(getActivity(), "Password Too Short", Toast.LENGTH_SHORT).show();
        }
           else{
               old_pwd_str = ed_old_pass.getText().toString();
               new_pwd_str = new_pwd.getText().toString();
               if(isNetworkAvailable()){
                   PasswordChanger pc = new PasswordChanger(getActivity());
                   pc.execute();
                   //Toast.makeText(getActivity(), ""+roll+new_pwd_str+old_pwd_str, Toast.LENGTH_SHORT).show();
               }
               else{
                   Toast.makeText(getActivity(), "No Internet Connection", Toast.LENGTH_SHORT).show();
               }

        }


       }
    }


    @Override
    public View onCreateView(LayoutInflater inflater, ViewGroup container,
                             Bundle savedInstanceState) {
        return inflater.inflate(R.layout.password_fd, container);
    }

    @Override
    public void onViewCreated(View view, @Nullable Bundle savedInstanceState) {
        super.onViewCreated(view, savedInstanceState);
        // Get field from view

        // Fetch arguments from bundle and set title

        roll = getArguments().getString("roll", "ROLL");
        getDialog().setTitle(roll);
        Button exit_btn = (Button) view.findViewById(R.id.exit_btn);
        exit_btn.setOnClickListener(this);
pb = (ProgressBar) view.findViewById(R.id.pass_pb);

        pb.setVisibility(ProgressBar.INVISIBLE);
        Button confirm_btn = (Button) view.findViewById(R.id.confirm_btn);
        confirm_btn.setOnClickListener(this);
        ed_old_pass = (EditText) view.findViewById(R.id.fd_old_pass);
        new_pwd = (EditText) view.findViewById(R.id.new_pwd);
        confirm_pwd = (EditText) view.findViewById(R.id.confirm_pwd);
        ed_old_pass.requestFocus();
        getDialog().getWindow().setSoftInputMode(
        WindowManager.LayoutParams.SOFT_INPUT_STATE_VISIBLE);
       // TextView fd_title = (TextView) view.findViewById(R.id.FD_title);

       /* Typeface custom_font1 = Typeface.createFromAsset(getAssets(), "fonts/Oswald-Regular.ttf");
        fd_title.setTypeface(custom_font1);
*/
        // Show soft keyboard automatically and request focus to field
//        mEditText.requestFocus();
        // getDialog().getWindow().setSoftInputMode(
        //       WindowManager.LayoutParams.SOFT_INPUT_STATE_VISIBLE);
    }

    public class PasswordChanger extends AsyncTask<Void,Void,String> {

        Context context;
        PasswordChanger(Context context)
        {
            this.context=context;
        }


        @Override
        protected String doInBackground(Void... params) {

            String login_url= null;
            if( Link.getInstance().getHashMapLink().containsKey("change_pass")){
                login_url = Link.getInstance().getHashMapLink().get("change_pass");
            }

            try{

                URL url =new URL(login_url);
                HttpURLConnection httpurlconnection= (HttpURLConnection) url.openConnection();
                httpurlconnection.setRequestProperty("Accept","text/html");
                httpurlconnection.setRequestMethod("POST");
                httpurlconnection.setDoOutput(true);
                httpurlconnection.setDoInput(true);

                OutputStream outputstream = httpurlconnection.getOutputStream();
                BufferedWriter bufferedwriter = new BufferedWriter(new OutputStreamWriter(outputstream, "UTF-8"));

                String post_data = URLEncoder.encode("roll", "UTF-8") + "=" + URLEncoder.encode(roll, "UTF-8") + "&"
                        + URLEncoder.encode("new", "UTF-8") + "=" + URLEncoder.encode(new_pwd_str, "UTF-8") + "&"
                        + URLEncoder.encode("old", "UTF-8") + "=" + URLEncoder.encode(old_pwd_str, "UTF-8");

                bufferedwriter.write(post_data);
                bufferedwriter.flush();
                bufferedwriter.close();

                InputStream inputstream= httpurlconnection.getInputStream();
                BufferedReader bufferedreader= new BufferedReader(new InputStreamReader(inputstream,"iso-8859-1"));
                String result="";
                String line="";
                while((line = bufferedreader.readLine())!=null){
                    result+=line;
                }
                bufferedreader.close();
                inputstream.close();
                httpurlconnection.disconnect();

                return result;

            }catch(MalformedURLException e){
                e.printStackTrace();
            } catch (IOException e) {
                e.printStackTrace();
            }


            return "null ghjgj";

        }


        @Override
        protected void onPreExecute() {
            pb.setVisibility(ProgressBar.VISIBLE);
            super.onPreExecute();
           // Toast.makeText(context, ""+roll, Toast.LENGTH_SHORT).show();
        }

        @Override
        protected void onPostExecute(String result ){

            pb.setVisibility(ProgressBar.INVISIBLE);
            if(result.equalsIgnoreCase("1")) {
                Toast.makeText(getActivity(), "Password Changed", Toast.LENGTH_SHORT).show();
            dismiss();
            }else  if(result.equalsIgnoreCase("2")) {
                Toast.makeText(getActivity(), "Wrong Password.", Toast.LENGTH_SHORT).show();
                ed_old_pass.setText("");
                new_pwd.setText("");
                confirm_pwd.setText("");
                ed_old_pass.requestFocus();
            }
            else{
                Toast.makeText(getActivity(), "Sorry, An Error Occured!", Toast.LENGTH_SHORT).show();
            }
        }



    }

    private boolean isNetworkAvailable() {
        ConnectivityManager connectivityManager
                = (ConnectivityManager) getActivity().getSystemService(Context.CONNECTIVITY_SERVICE);
        NetworkInfo activeNetworkInfo = connectivityManager.getActiveNetworkInfo();
        return activeNetworkInfo != null && activeNetworkInfo.isConnected();
    }

}