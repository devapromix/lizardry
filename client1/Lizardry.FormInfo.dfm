object FormInfo: TFormInfo
  Left = 0
  Top = 0
  BorderIcons = [biSystemMenu]
  BorderStyle = bsSingle
  Caption = 'Lizardry'
  ClientHeight = 458
  ClientWidth = 749
  Color = clBtnFace
  Font.Charset = DEFAULT_CHARSET
  Font.Color = clWindowText
  Font.Height = -11
  Font.Name = 'Tahoma'
  Font.Style = []
  OldCreateOrder = False
  PixelsPerInch = 96
  TextHeight = 13
  object PageControl1: TPageControl
    Left = 0
    Top = 0
    Width = 749
    Height = 458
    ActivePage = TabSheet1
    Align = alClient
    TabOrder = 0
    object TabSheet1: TTabSheet
      Caption = #1055#1086#1089#1083'. JSON'
      object LocMemo: TRichEdit
        Left = 0
        Top = 0
        Width = 741
        Height = 430
        Align = alClient
        Font.Charset = RUSSIAN_CHARSET
        Font.Color = clWindowText
        Font.Height = -11
        Font.Name = 'Tahoma'
        Font.Style = []
        ParentFont = False
        ReadOnly = True
        ScrollBars = ssVertical
        TabOrder = 0
        Zoom = 100
      end
    end
    object TabSheet2: TTabSheet
      Caption = #1055#1088#1077#1076#1084#1077#1090#1099
      ImageIndex = 1
      object ItemMemo: TRichEdit
        Left = 0
        Top = 0
        Width = 741
        Height = 430
        Align = alClient
        Font.Charset = RUSSIAN_CHARSET
        Font.Color = clWindowText
        Font.Height = -11
        Font.Name = 'Tahoma'
        Font.Style = []
        ParentFont = False
        ReadOnly = True
        ScrollBars = ssVertical
        TabOrder = 0
        Zoom = 100
      end
    end
    object TabSheet3: TTabSheet
      Caption = #1048#1079#1086#1073#1088#1072#1078#1077#1085#1080#1103
      ImageIndex = 2
      object ResMemo: TMemo
        Left = 0
        Top = 25
        Width = 741
        Height = 405
        Align = alClient
        ReadOnly = True
        ScrollBars = ssVertical
        TabOrder = 0
      end
      object ImagesPath: TPanel
        Left = 0
        Top = 0
        Width = 741
        Height = 25
        Align = alTop
        Alignment = taLeftJustify
        BevelOuter = bvNone
        Caption = 'ImagesPath'
        TabOrder = 1
      end
    end
    object TabSheet4: TTabSheet
      Caption = #1054#1096#1080#1073#1082#1080
      ImageIndex = 3
      object ErrorMemo: TMemo
        Left = 0
        Top = 0
        Width = 741
        Height = 430
        Align = alClient
        ReadOnly = True
        ScrollBars = ssVertical
        TabOrder = 0
      end
    end
    object TabSheet5: TTabSheet
      Caption = #1048#1085#1074#1077#1085#1090#1072#1088#1100
      ImageIndex = 4
      object InvMemo: TMemo
        Left = 0
        Top = 0
        Width = 741
        Height = 430
        Align = alClient
        ReadOnly = True
        ScrollBars = ssVertical
        TabOrder = 0
      end
    end
  end
end
