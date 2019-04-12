package com.ExodiaSolutions.sunnynarang.itmexodia;

import android.app.AlertDialog;
import android.app.ProgressDialog;
import android.content.Context;
import android.content.Intent;
import android.content.SharedPreferences;
import android.graphics.Color;
import android.net.ConnectivityManager;
import android.net.NetworkInfo;
import android.net.Uri;
import android.os.AsyncTask;
import android.os.Build;
import android.os.Bundle;
import android.os.Handler;
import android.support.v7.app.ActionBar;
import android.support.v7.app.AppCompatActivity;
import android.util.Log;
import android.view.View;
import android.view.Window;
import android.view.WindowManager;
import android.widget.Button;
import android.widget.CheckBox;
import android.widget.EditText;
import android.widget.LinearLayout;
import android.widget.Toast;

import com.ExodiaSolutions.sunnynarang.itmexodia.guest.GuestHome;
import com.ExodiaSolutions.sunnynarang.itmexodia.students.Dashboard;
import com.ExodiaSolutions.sunnynarang.itmexodia.teachers.Main2Activity;
import com.ExodiaSolutions.sunnynarang.itmexodia.teachers.MainActivity;
import com.facebook.drawee.backends.pipeline.Fresco;
import com.facebook.drawee.generic.GenericDraweeHierarchy;
import com.facebook.drawee.generic.GenericDraweeHierarchyBuilder;
import com.facebook.drawee.generic.RoundingParams;
import com.facebook.drawee.view.SimpleDraweeView;
import com.google.android.gms.appindexing.Action;
import com.google.android.gms.appindexing.Thing;

import org.json.JSONArray;
import org.json.JSONException;
import org.json.JSONObject;

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
import java.util.Random;

public class login extends AppCompatActivity implements ObjectIO.WriterListener{
    EditText usernameEt, passwordEt;
    CheckBox checkBox;
    LinearLayout linearLayout;
    ProgressDialog pd;
    private SharedPreferences mSettings;
    private SharedPreferences.Editor Editor;
    String username="";
    String pass="";

    String login_url;

    String[] color = {"EF5350", "AB47BC", "7E57C2", "5C6BC0", "42A5F5", "29B6F6", "26A69A", "FF7043", "BDBDBD", "78909C"};
    Button b;
    /**
     * ATTENTION: This was auto-generated to implement the App Indexing API.
     * See https://g.co/AppIndexing/AndroidStudio for more information.
     */
    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        Fresco.initialize(login.this);
        setContentView(R.layout.activity_login);
        ActionBar actionBar = getSupportActionBar(); // or getActionBar();
        actionBar.hide();
        /*getSupportActionBar().setTitle("LOGIN");
        getSupportActionBar().setDisplayOptions(ActionBar.DISPLAY_SHOW_CUSTOM);
        getSupportActionBar().setCustomView(R.layout.action_bar);*/

        linearLayout = (LinearLayout) findViewById(R.id.login_bk);
        int i = new Random().nextInt(10);

        linearLayout.setBackgroundColor(Color.parseColor("#D9"+color[i]));
        Window window= login.this.getWindow();
        window.addFlags(WindowManager.LayoutParams.FLAG_DRAWS_SYSTEM_BAR_BACKGROUNDS);
        window.clearFlags(WindowManager.LayoutParams.FLAG_TRANSLUCENT_STATUS);
        if (Build.VERSION.SDK_INT >= Build.VERSION_CODES.LOLLIPOP) {
            window.setStatusBarColor(Color.parseColor("#"+color[i]));
        }
       /* b = (Button) findViewById(R.id.login);
        b.setBackgroundColor(Color.parseColor(color[i]));
        b.getBackground().setAlpha(2000);
*/
        //TextView tv = (TextView) findViewById(R.id.sample);
        //Typeface custom_font = Typeface.createFromAsset(getAssets(), "fonts/1942.ttf");
        //tv.setTypeface(custom_font);
        usernameEt = (EditText) findViewById(R.id.user);
        passwordEt = (EditText) findViewById(R.id.pass);
        passwordEt.setOnFocusChangeListener(new View.OnFocusChangeListener() {
            @Override
            public void onFocusChange(View v, boolean hasFocus) {
                if(hasFocus)
                {
                    Uri imageUri = Uri.parse("http://mis.itmuniversity.ac.in/itmzone/StudentPhoto/"+usernameEt.getText().toString().toUpperCase()+".jpeg");
                    // Toast.makeText(login.this,img,Toast.LENGTH_LONG).show();
                    SimpleDraweeView draweeView = (SimpleDraweeView) findViewById(R.id.login_img);
                    //  Drawable myIcon = getResources().getDrawable( R.drawable.hello );
                    GenericDraweeHierarchyBuilder builder =
                            new GenericDraweeHierarchyBuilder(getResources());
                    GenericDraweeHierarchy hierarchy = builder
                            .setFadeDuration(600)
                            .setPlaceholderImage(getResources().getDrawable( R.drawable.hello))
                            .build();
                    draweeView.setHierarchy(hierarchy);

                    RoundingParams roundingParams = RoundingParams.fromCornersRadius(5f);

                    roundingParams.setRoundAsCircle(true);
                    //   roundingParams.setBorder(Color.parseColor("#ffffff"), 8);
                    draweeView.getHierarchy().setRoundingParams(roundingParams);
                    draweeView.setImageURI(imageUri);
                }
            }
        });



        checkBox = (CheckBox) findViewById(R.id.remember_me);
        mSettings = this.getSharedPreferences("settings", 0);
        Editor = mSettings.edit();




        if (getIntent().getBooleanExtra("remember_not", false)) {
            Editor.putString("username", "");
            Editor.putString("password", "");
            Editor.putString("remember_me", "");
            Editor.apply();
            //Toast.makeText(login.this, "Log Out", Toast.LENGTH_SHORT).show();
        } else if (mSettings.getString("remember_me", "").equalsIgnoreCase("2")||mSettings.getString("remember_me", "").equalsIgnoreCase("3")) {
            Intent intent = new Intent(login.this, Main2Activity.class);
            intent.putExtra("username", mSettings.getString("username", ""));
            intent.putExtra("name", mSettings.getString("name",""));
           // intent.putExtra("image",mSettings.getString("image",""));

            login.this.finish();
            startActivity(intent);
        } else if (mSettings.getString("remember_me", "").equalsIgnoreCase("1")) {
            Intent intent = new Intent(login.this, Dashboard.class);
            intent.putExtra("username", mSettings.getString("username", ""));
            intent.putExtra("name", mSettings.getString("name",""));
            intent.putExtra("section", mSettings.getString("section",""));
            //intent.putExtra("image",mSettings.getString("image",""));

            login.this.finish();
            startActivity(intent);
        }

        // ATTENTION: This was auto-generated to implement the App Indexing API.
        // See https://g.co/AppIndexing/AndroidStudio for more information.
    }

    public void Onlogin(View view) {

        username = usernameEt.getText().toString();

        pass = passwordEt.getText().toString();

        if(usernameEt.getText().toString().toLowerCase().contains("@itmuniversity.ac.in")){
            login_url = "http://mis.itmuniversity.ac.in/itmzone/misapp/new_login_faculty.php";
            //Toast.makeText(this, "Its Faculty", Toast.LENGTH_SHORT).show();
        }
        else {
            login_url = "http://mis.itmuniversity.ac.in/itmzone/misapp/new_login.php";
           // Toast.makeText(this, "Its Student", Toast.LENGTH_SHORT).show();
        }


        String type = "login";
        if (usernameEt.getText().toString().equalsIgnoreCase("") || passwordEt.getText().toString().equalsIgnoreCase("")) {
            Toast.makeText(login.this, "Please Enter Correct Info", Toast.LENGTH_SHORT).show();
        } else {
            if(isNetworkAvailable()){
            final BackgroundWorker backgroundWorker = new BackgroundWorker(this);
            backgroundWorker.execute(type, username, pass);

                Handler handler = new Handler();
                handler.postDelayed(new Runnable()
                {
                    @Override
                    public void run() {
                        if ( backgroundWorker.getStatus() == AsyncTask.Status.RUNNING )
                        {
                            backgroundWorker.cancel(true);
                            Toast.makeText(login.this, "Time OUT", Toast.LENGTH_SHORT).show();
                            if(pd.isIndeterminate())
                            pd.dismiss();
                        }
                    }
                }, 20000 );
            }
            else{
                Toast.makeText(login.this, "No Internet Connection!", Toast.LENGTH_SHORT).show();
            }
        }
    }
    private boolean isNetworkAvailable() {
        ConnectivityManager connectivityManager
                = (ConnectivityManager) getSystemService(Context.CONNECTIVITY_SERVICE);
        NetworkInfo activeNetworkInfo = connectivityManager.getActiveNetworkInfo();
        return activeNetworkInfo != null && activeNetworkInfo.isConnected();
    }

    @Override
    public void ObjectWriterCallback(boolean result) {

    }


    public class BackgroundWorker extends AsyncTask<String, Void, String> {

        Context context;
        AlertDialog alertdialog;

        BackgroundWorker(Context context) {
            this.context = context;
        }


        @Override
        protected String doInBackground(String... params) {
            String type = params[0];
            String username = params[1];
            String pass = params[2];
            if (type.equals("login")) {
                try {

                    URL url = new URL(login_url);
                    HttpURLConnection httpurlconnection = (HttpURLConnection) url.openConnection();
                   httpurlconnection.setRequestProperty("Accept","text/html");
                    httpurlconnection.setRequestMethod("POST");
                     httpurlconnection.setDoOutput(true);
                    httpurlconnection.setDoInput(true);;
                     OutputStream outputstream = httpurlconnection.getOutputStream();
                    BufferedWriter bufferedwriter = new BufferedWriter(new OutputStreamWriter(outputstream, "UTF-8"));

                    String post_data = URLEncoder.encode("username", "UTF-8") + "=" + URLEncoder.encode(username, "UTF-8") + "&"
                            + URLEncoder.encode("key", "UTF-8") + "=" + URLEncoder.encode(pass, "UTF-8");
                    bufferedwriter.write(post_data);
                    bufferedwriter.flush();
                    bufferedwriter.close();

                    InputStream inputstream = httpurlconnection.getInputStream();

                    BufferedReader bufferedreader = new BufferedReader(new InputStreamReader(inputstream, "iso-8859-1"));
                    String result = "";
                    String line = "";
                    while ((line = bufferedreader.readLine()) != null) {
                        result += line;
                    }
                    bufferedreader.close();
                    inputstream.close();
                    httpurlconnection.disconnect();

                    return result;

                } catch (MalformedURLException e) {
                    e.printStackTrace();
                } catch (IOException e) {
                    e.printStackTrace();
                }
            }

            return "null";

        }


        @Override
        protected void onPreExecute() {
            //Toast.makeText(context, ""+username+pass, Toast.LENGTH_SHORT).show();
            pd = new ProgressDialog(context);
            pd.setTitle("Logging In");
            pd.setMessage("Please wait.. Authenticating.");
            pd.setCancelable(false);

            pd.show();

            alertdialog = new AlertDialog.Builder(context).create();
            alertdialog.setTitle("Login Status");
        }

        @Override
        protected void onPostExecute(String result) {
            //alertdialog.setMessage(result);
            //alertdialog.show();

            pd.dismiss();
            JSONObject jsonObject=null;
            String res=null;
            if(usernameEt.getText().toString().toLowerCase().contains("@itmuniversity.ac.in"))
                res="2";
            else
                res="1";



            if(result.equalsIgnoreCase("0"))
            {
                Toast.makeText(login.this, "Please Get Your Key from MIS Web", Toast.LENGTH_SHORT).show();
                usernameEt.setText("");
                passwordEt.setText("");
            }else if(result.equalsIgnoreCase("null ghjgj")){

                Toast.makeText(login.this, "Please Update The App.", Toast.LENGTH_SHORT).show();
            }

            else {

                try {
                    String obj[] = result.split("``%f%``");

                    jsonObject = new JSONObject(obj[0]);
                    if(obj.length>0){
                            Link link = Link.getInstance();
                            JSONArray jsonArray = new JSONArray(obj[1]);
                            link.setHashMapLink(jsonArray);
                            ObjectIO objectIO = new ObjectIO(context);
                            objectIO.writeObj(link);
                        }

                } catch (JSONException e) {
                    e.printStackTrace();
                }



                if (res.equalsIgnoreCase("2")||res.equalsIgnoreCase("3")) {
                    Intent intent = new Intent(login.this, Main2Activity.class);
                    intent.putExtra("username", jsonObject.optString("email"));
                    intent.putExtra("name", jsonObject.optString("name"));

                    if (checkBox.isChecked()) {
                        Editor.putString("username", jsonObject.optString("email"));
                        Editor.putString("name", jsonObject.optString("name"));
                        Editor.putString("password", pass);
                        Editor.putString("remember_me", "2");
                        Editor.apply();
                    }
                    login.this.finish();
                    startActivity(intent);
                } else if (res.equalsIgnoreCase("1")) {

                    Intent intent = new Intent(login.this, Dashboard.class);
                    intent.putExtra("username", jsonObject.optString("username"));
                    intent.putExtra("name",jsonObject.optString("name"));
                    intent.putExtra("section",jsonObject.optString("section"));
              if (checkBox.isChecked()) {

                       Editor.putString("username",jsonObject.optString("username"));
                        Editor.putString("password", pass);
                        Editor.putString("name",jsonObject.optString("name"));
                        Editor.putString("section",jsonObject.optString("section"));
                       Editor.putString("remember_me", "1");
                        Editor.apply();
                    }
                    login.this.finish();
                    startActivity(intent);
                }
            }
        }

        @Override
        protected void onProgressUpdate(Void... values) {
            super.onProgressUpdate(values);
        }

    }

    public void close(View v) {
        Intent i = new Intent(login.this, MainActivity.class);
        startActivity(i);
    }
        public void guest(View v){
            Intent i = new Intent(login.this,GuestHome.class);
            startActivity(i);
        }

    public void forget(View v){
        Intent i = new Intent(Intent.ACTION_VIEW, Uri.parse("http://mis.itmuniversity.ac.in/itmzone/"));
        startActivity(i);
    }


}
