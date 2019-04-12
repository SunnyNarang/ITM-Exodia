package com.ExodiaSolutions.sunnynarang.itmexodia.teachers;

import android.app.ProgressDialog;
import android.content.Context;
import android.content.Intent;
import android.net.ConnectivityManager;
import android.net.NetworkInfo;
import android.net.Uri;
import android.os.AsyncTask;
import android.os.Handler;
import android.support.v7.app.ActionBar;
import android.support.v7.app.AppCompatActivity;
import android.os.Bundle;
import android.view.LayoutInflater;
import android.view.MenuItem;
import android.view.View;
import android.view.ViewGroup;
import android.widget.AdapterView;
import android.widget.ArrayAdapter;
import android.widget.ListView;
import android.widget.TextView;
import android.widget.Toast;

import com.ExodiaSolutions.sunnynarang.itmexodia.R;
import com.ExodiaSolutions.sunnynarang.itmexodia.students.files_class;

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
import java.util.ArrayList;

public class ViewNotes extends AppCompatActivity {
    String course_select,branch_select,sem_select,subject_select,roll,your;
    ArrayList<files_class> arrayList = new ArrayList<>();
    ProgressDialog pd;
    CustomAdapter3 adapter;
    NotesLoader notesloader;
    @Override
    protected void onPause() {
        if(notesloader.getStatus()==AsyncTask.Status.RUNNING)
            notesloader.cancel(true);
        super.onPause();
    }

    @Override
    public boolean onOptionsItemSelected(MenuItem item) {
        switch (item.getItemId()) {
            case android.R.id.home:
                //Write your logic here
                ViewNotes.this.finish();
                this.finish();
                return true;
            default:
                return super.onOptionsItemSelected(item);
        }
    }

    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.activity_view_notes);
        ActionBar actionBar = getSupportActionBar();
        actionBar.setTitle("View Notes");
        actionBar.setHomeButtonEnabled(true);
        actionBar.setDisplayHomeAsUpEnabled(true);
        course_select = getIntent().getStringExtra("course");
        branch_select = getIntent().getStringExtra("branch");
        sem_select = getIntent().getStringExtra("sem");
        subject_select = getIntent().getStringExtra("subject");
        your = getIntent().getStringExtra("your");
        roll = getIntent().getStringExtra("roll");
        //Toast.makeText(this, "course:"+course_select+"\nbranch:"+branch_select+"\nsem:"+sem_select+"\nsubject:"+subject_select+"\nroll:"+roll+"\nyour:"+your, Toast.LENGTH_SHORT).show();

       if(isNetworkAvailable()){

           notesloader = new NotesLoader();
           notesloader.execute();

           Handler handler = new Handler();
           handler.postDelayed(new Runnable()
           {
               @Override
               public void run() {
                   if ( notesloader.getStatus() == AsyncTask.Status.RUNNING )
                   {notesloader.cancel(true);
                       Toast.makeText(ViewNotes.this, "Time OUT", Toast.LENGTH_SHORT).show();
                       if(pd.isIndeterminate())
                       pd.dismiss();
                   }
               }
           }, 20000 );
       }
        else {
           Toast.makeText(this, "Please Connect To Internet", Toast.LENGTH_SHORT).show();
       }
        adapter = new CustomAdapter3(ViewNotes.this,arrayList);
        ListView lv = (ListView) findViewById(R.id.view_notes_lv);
        lv.setAdapter(adapter);
        lv.setOnItemClickListener(
                new AdapterView.OnItemClickListener() {
                    public void onItemClick(AdapterView<?> parent, View v, int pos, long id) {

                        files_class files_class = arrayList.get(pos);

                        Intent i = new Intent(Intent.ACTION_VIEW, Uri.parse("https://exodia-incredible100rav.c9users.io/exodia/download.php?file="+files_class.getPdf()+""));
                        startActivity(i);


                    }
                }


        );
    }

    class CustomAdapter3 extends ArrayAdapter<files_class> {
        Context c;

        public CustomAdapter3(Context context, ArrayList<files_class> arrayList) {
            super(context, R.layout.files_card, arrayList);
            this.c = context;
        }


        @Override
        public View getView(int pos, View convertView, ViewGroup parent) {

            LayoutInflater li = (LayoutInflater) c.getSystemService(c.LAYOUT_INFLATER_SERVICE);
            convertView = li.inflate(R.layout.files_card, parent, false);
            files_class f = arrayList.get(pos);
            TextView title = (TextView) convertView.findViewById(R.id.files_title);
            TextView desc = (TextView) convertView.findViewById(R.id.files_desc);
            TextView teacher = (TextView) convertView.findViewById(R.id.files_teacher);
            title.setText(f.getTitle());
            desc.setText(f.getDesc());
            teacher.setText(f.getTeacher());
            return convertView;

        }
    }


    public class NotesLoader extends AsyncTask<String, Void, String>
    {
        String res;

        @Override
        protected String doInBackground(String... params) {



            String login_url = "https://exodia-incredible100rav.c9users.io/android/php/getnotes_new.php";

            try {


                URL url = new URL(login_url);
                HttpURLConnection httpurlconnection = (HttpURLConnection) url.openConnection();
                httpurlconnection.setRequestMethod("POST");
                httpurlconnection.setDoOutput(true);
                httpurlconnection.setDoInput(true);

                OutputStream outputstream = httpurlconnection.getOutputStream();
                BufferedWriter bufferedwriter = new BufferedWriter(new OutputStreamWriter(outputstream, "UTF-8"));

                String post_data = URLEncoder.encode("course", "UTF-8") + "=" + URLEncoder.encode(course_select, "UTF-8")+ "&"
                        + URLEncoder.encode("branch", "UTF-8") + "=" + URLEncoder.encode(branch_select, "UTF-8")+ "&"
                        + URLEncoder.encode("subject", "UTF-8") + "=" + URLEncoder.encode(subject_select, "UTF-8")+ "&"
                        + URLEncoder.encode("sem", "UTF-8") + "=" + URLEncoder.encode(sem_select, "UTF-8")+ "&"
                        + URLEncoder.encode("roll", "UTF-8") + "=" + URLEncoder.encode(roll, "UTF-8")+ "&"
                        + URLEncoder.encode("your", "UTF-8") + "=" + URLEncoder.encode(your, "UTF-8");
                bufferedwriter.write(post_data);
                bufferedwriter.flush();
                bufferedwriter.close();


                InputStream inputstream = httpurlconnection.getInputStream();
                BufferedReader bufferedreader = new BufferedReader(new InputStreamReader(inputstream, "iso-8859-1"));
                res = "";
                String line = "";
                while ((line = bufferedreader.readLine()) != null) {
                    res += line;
                }
                bufferedreader.close();
                inputstream.close();
                httpurlconnection.disconnect();
                return res;
            } catch (MalformedURLException e) {
                e.printStackTrace();
            } catch (IOException e) {
                e.printStackTrace();
            }


            return "";
        }

        @Override
        protected void onPreExecute() {
            super.onPreExecute();
            pd = new ProgressDialog(ViewNotes.this);
            pd.setTitle("Loading.");
            pd.setMessage("Please wait... \nLoading Student List.");
            pd.setCancelable(false);
            pd.show();

        }

        @Override
        protected void onPostExecute(String s) {
            pd.dismiss();
            arrayList.clear();
            //Toast.makeText(ViewNotes.this, ""+s, Toast.LENGTH_SHORT).show();
            if(s.equalsIgnoreCase("0"))
            {
                Toast.makeText(ViewNotes.this, "Sorry Nothing Found", Toast.LENGTH_SHORT).show();
                finish();
            }
            //Toast.makeText(MyActivity.this,s,Toast.LENGTH_LONG).show();
            //Toast.makeText(ViewNotes.this, ""+s, Toast.LENGTH_SHORT).show();
            try {
                JSONArray array = new JSONArray(s);
                for(int i=0;i<array.length();i++){
                    JSONObject obj = array.optJSONObject(i);
                    files_class f = new files_class(obj.getString("title"),obj.getString("file"),obj.getString("description"),obj.getString("name"));
                    arrayList.add(f);
                }

                adapter.notifyDataSetChanged();
            } catch (JSONException e) {
                e.printStackTrace();
            }


        }

    }


    private boolean isNetworkAvailable() {
        ConnectivityManager connectivityManager
                = (ConnectivityManager) getSystemService(Context.CONNECTIVITY_SERVICE);
        NetworkInfo activeNetworkInfo = connectivityManager.getActiveNetworkInfo();
        return activeNetworkInfo != null && activeNetworkInfo.isConnected();
    }


}
